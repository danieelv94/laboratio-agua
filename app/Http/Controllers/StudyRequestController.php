<?php

namespace App\Http\Controllers;

use App\Models\StudyRequest;
use Illuminate\Http\Request;

class StudyRequestController extends Controller
{
    /**
     * Show the public request form.
     */
    public function create()
    {
        return view('study-requests.create');
    }

    public function store(Request $request)
    {
        // 1. Validate request
        $validated = $request->validate([
            // Solicitante
            'solicitante' => 'required|string|max:255',
            'representante' => 'required|string|max:255',
            'puesto_departamento' => 'required|string|max:255',
            'direccion' => 'required|string',
            'email' => 'required|email|max:255',
            'telefono' => 'nullable|string|max:255',

            // Muestra
            'cantidad_muestras' => 'required|integer|min:1',
            'puntos_muestreo' => 'required|array|min:1',
            'punto_muestreo_especificar' => 'nullable|string|max:255',
            'tipos_muestra' => 'required|array|min:1',
            'normativas' => 'required|array|min:1',
            'normativa_especificar' => 'nullable|string|max:255',

            // Facturación (Opcional)
            'razon_social' => 'nullable|string|max:255',
            'rfc' => 'nullable|string|min:12|max:13',
            'direccion_fiscal' => 'nullable|string',
            'uso_cfdi' => 'nullable|string|max:255',
            'metodo_pago' => 'nullable|string|max:255',
            'forma_pago' => 'nullable|string|max:255',
            'ultimos_cuatro_digitos' => 'nullable|string|size:4|regex:/^[0-9]+$/',
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ingresar una dirección de correo electrónico válida.',
            'cantidad_muestras.required' => 'Debe ingresar la cantidad de análisis/muestras.',
            'cantidad_muestras.min' => 'La cantidad mínima de análisis debe ser 1.',
            'puntos_muestreo.required' => 'Debe seleccionar al menos un punto de muestreo.',
            'tipos_muestra.required' => 'Debe seleccionar al menos un tipo de muestra.',
            'normativas.required' => 'Debe seleccionar al menos una normativa aplicable.',
            'ultimos_cuatro_digitos.size' => 'Deben ser exactamente los últimos 4 dígitos de la cuenta.',
            'ultimos_cuatro_digitos.regex' => 'Los últimos 4 dígitos deben contener únicamente números.',
            'rfc.min' => 'El RFC debe tener entre 12 y 13 caracteres.',
            'rfc.max' => 'El RFC debe tener entre 12 y 13 caracteres.',
        ]);

        // Custom validation logic for dynamic specifies to avoid validator complexity issues
        if (in_array('OTRO', $request->input('puntos_muestreo', [])) && empty($request->input('punto_muestreo_especificar'))) {
            return back()->withErrors(['punto_muestreo_especificar' => 'Debe especificar el punto de muestreo adicional.'])->withInput();
        }
        if (in_array('OTRA', $request->input('normativas', [])) && empty($request->input('normativa_especificar'))) {
            return back()->withErrors(['normativa_especificar' => 'Debe especificar la otra norma a cumplir.'])->withInput();
        }

        // 2. Generate unique reference
        $validated['referencia_bancaria'] = StudyRequest::generateUniqueReference();
        
        // Default recovery fee values
        $validated['servicio_analisis'] = 'Análisis fisicoquímico bacteriológico de agua (Con toma de muestra)';
        $validated['importe'] = $validated['cantidad_muestras'] * 7698.02;
        $validated['status'] = 'pendiente';

        // 3. Save
        $studyRequest = StudyRequest::create($validated);

        // 4. Redirect to confirmation page
        return redirect()->route('solicitud.ver', ['reference' => $studyRequest->referencia_bancaria])
                         ->with('success', '¡Solicitud registrada con éxito!');
    }

    /**
     * Display the payment details and current status of a specific request.
     */
    public function show($reference)
    {
        $studyRequest = StudyRequest::where('referencia_bancaria', $reference)->firstOrFail();

        return view('study-requests.show', compact('studyRequest'));
    }

    /**
     * Show the status check search form.
     */
    public function statusForm()
    {
        return view('study-requests.status');
    }

    /**
     * Process status check submission.
     */
    public function checkStatus(Request $request)
    {
        $request->validate([
            'referencia_bancaria' => 'required|string',
        ]);

        $reference = trim($request->input('referencia_bancaria'));

        $studyRequest = StudyRequest::where('referencia_bancaria', $reference)->first();

        if (!$studyRequest) {
            return back()->withErrors(['referencia_bancaria' => 'No se encontró ninguna solicitud con esa referencia bancaria o folio.'])->withInput();
        }

        return redirect()->route('solicitud.ver', ['reference' => $studyRequest->referencia_bancaria]);
    }

    /**
     * Upload the payment voucher for a study request.
     */
    public function uploadVoucher(Request $request, $reference)
    {
        $studyRequest = StudyRequest::where('referencia_bancaria', $reference)->firstOrFail();

        $request->validate([
            'comprobante_pago' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'comprobante_pago.required' => 'Debe seleccionar un archivo para el comprobante.',
            'comprobante_pago.mimes' => 'El comprobante debe ser un archivo en formato PDF, JPG, JPEG o PNG.',
            'comprobante_pago.max' => 'El tamaño máximo del archivo es 5 MB.',
        ]);

        if ($request->hasFile('comprobante_pago')) {
            $path = $request->file('comprobante_pago')->store('vouchers', 'public');
            $studyRequest->update([
                'comprobante_pago' => $path,
            ]);
            return back()->with('success', '¡Comprobante de pago subido correctamente! Su pago está siendo validado.');
        }

        return back()->withErrors(['comprobante_pago' => 'No se pudo cargar el archivo.']);
    }

    /**
     * Submit the satisfaction survey for a study request.
     */
    public function submitSurvey(Request $request, $reference)
    {
        $studyRequest = StudyRequest::where('referencia_bancaria', $reference)->firstOrFail();

        // 1. Verify that request status is indeed completed and results PDF is uploaded
        if ($studyRequest->status !== 'completado' || !$studyRequest->archivo_resultados) {
            return back()->withErrors(['survey' => 'Los resultados no están listos todavía.']);
        }

        // 2. Validate survey answers
        $rules = [
            'encuesta_mejoras' => 'nullable|string|max:1000',
            'encuesta_comentarios' => 'nullable|string|max:1000',
        ];
        $messages = [];

        for ($i = 1; $i <= 10; $i++) {
            $rules["encuesta_p{$i}"] = 'required|integer|min:1|max:5';
            $messages["encuesta_p{$i}.required"] = "Debe responder la pregunta {$i} de la encuesta.";
        }

        $request->validate($rules, $messages);

        // 3. Compute survey average
        $sum = 0;
        for ($i = 1; $i <= 10; $i++) {
            $sum += (int) $request->input("encuesta_p{$i}");
        }
        $average = $sum / 10.0;

        // 4. Update study request
        $updateData = [
            'encuesta_respondida' => true,
            'encuesta_promedio' => $average,
            'encuesta_mejoras' => $request->input('encuesta_mejoras'),
            'encuesta_comentarios' => $request->input('encuesta_comentarios'),
        ];

        for ($i = 1; $i <= 10; $i++) {
            $updateData["encuesta_p{$i}"] = (int) $request->input("encuesta_p{$i}");
        }

        $studyRequest->update($updateData);

        return back()->with('success', '¡Gracias por contestar la encuesta! Ya puede descargar sus resultados.');
    }
}
