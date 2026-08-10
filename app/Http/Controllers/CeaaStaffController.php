<?php

namespace App\Http\Controllers;

use App\Models\StudyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CeaaStaffController extends Controller
{
    /**
     * Display a listing of requests in the admin dashboard.
     */
    public function index(Request $request)
    {
        $query = StudyRequest::orderBy('created_at', 'desc');

        // Filter based on user role: administracion only sees requests requesting an invoice (non-null RFC)
        $user = auth()->user();
        if ($user && $user->role === 'administracion') {
            $query->whereNotNull('rfc');
        }

        // Apply status filter if present
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Apply search filter if present
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('solicitante', 'like', "%{$search}%")
                  ->orWhere('representante', 'like', "%{$search}%")
                  ->orWhere('referencia_bancaria', 'like', "%{$search}%");
            });
        }

        $requests = $query->paginate(15);

        return view('dashboard', compact('requests'));
    }

    /**
     * Show the detailed view for a single request in the dashboard.
     */
    public function show(StudyRequest $studyRequest)
    {
        // Fetch all unique occupied dates (YYYY-MM-DD) from other requests
        $occupiedDates = StudyRequest::whereNotNull('fecha_muestreo')
            ->where('id', '!=', $studyRequest->id)
            ->pluck('fecha_muestreo')
            ->map(fn($date) => $date->format('Y-m-d'))
            ->unique()
            ->values()
            ->toArray();

        return view('dashboard.show', compact('studyRequest', 'occupiedDates'));
    }

    /**
     * Update the request details (status, collection date, comments, results PDF).
     */
    public function update(Request $request, StudyRequest $studyRequest)
    {
        $request->validate([
            'status' => 'required|in:pendiente,pago_verificado,muestreo_programado,en_analisis,completado,rechazado',
            'fecha_muestreo' => [
                'required_if:status,muestreo_programado',
                'nullable',
                'date',
                function ($attribute, $value, $fail) use ($studyRequest) {
                    if ($value) {
                        $dateString = date('Y-m-d', strtotime($value));
                        $conflict = StudyRequest::where('id', '!=', $studyRequest->id)
                            ->whereNotNull('fecha_muestreo')
                            ->whereDate('fecha_muestreo', $dateString)
                            ->exists();

                        if ($conflict) {
                            $fail('El día seleccionado ya tiene una visita de muestreo programada.');
                        }
                    }
                }
            ],
            'comentarios_staff' => 'required_if:status,rechazado|nullable|string',
            'archivo_resultados' => ($studyRequest->archivo_resultados ? 'nullable' : 'required_if:status,completado') . '|file|mimes:pdf|max:10240', // PDF up to 10MB
        ], [
            'fecha_muestreo.required_if' => 'Debe ingresar la fecha y hora de la visita para programar el muestreo.',
            'comentarios_staff.required_if' => 'Debe ingresar el motivo del rechazo para poder cancelar la solicitud.',
            'archivo_resultados.required_if' => 'Debe cargar el archivo PDF de resultados para concluir el trámite.',
        ]);

        // Enforce that payment can only be verified if a voucher has been uploaded
        if ($request->input('status') === 'pago_verificado' && !$studyRequest->comprobante_pago) {
            return back()->withErrors(['status' => 'No se puede validar el pago debido a que el solicitante aún no ha cargado su comprobante de pago.'])->withInput();
        }

        $data = $request->only(['status', 'fecha_muestreo', 'comentarios_staff']);

        // Handle file upload
        if ($request->hasFile('archivo_resultados')) {
            // Delete old file if exists
            if ($studyRequest->archivo_resultados) {
                Storage::disk('public')->delete($studyRequest->archivo_resultados);
            }

            // Save new file
            $file = $request->file('archivo_resultados');
            $filename = 'resultados_' . $studyRequest->referencia_bancaria . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('resultados', $filename, 'public');
            $data['archivo_resultados'] = $path;
        }

        $studyRequest->update($data);

        return redirect()->route('dashboard.solicitud', $studyRequest->id)
                         ->with('success', 'La solicitud ha sido actualizada correctamente.');
     }

    /**
     * Upload the ZIP invoice file for a request.
     */
    public function uploadInvoice(Request $request, StudyRequest $studyRequest)
    {
        $request->validate([
            'archivo_factura' => 'required|file|mimes:zip|max:10240', // ZIP up to 10MB
        ], [
            'archivo_factura.required' => 'Debe seleccionar un archivo ZIP para cargar.',
            'archivo_factura.mimes' => 'El archivo debe estar en formato ZIP.',
            'archivo_factura.max' => 'El archivo ZIP no debe pesar más de 10 MB.',
        ]);

        $data = [];

        // Handle file upload
        if ($request->hasFile('archivo_factura')) {
            // Delete old file if exists
            if ($studyRequest->archivo_factura) {
                Storage::disk('public')->delete($studyRequest->archivo_factura);
            }

            // Save new file
            $file = $request->file('archivo_factura');
            $filename = 'factura_' . $studyRequest->referencia_bancaria . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('facturas', $filename, 'public');
            $data['archivo_factura'] = $path;
        }

        $studyRequest->update($data);

        return redirect()->route('dashboard.solicitud', $studyRequest->id)
                         ->with('success', 'La factura ha sido cargada correctamente.');
    }
}
