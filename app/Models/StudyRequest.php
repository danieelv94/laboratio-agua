<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'solicitante',
        'representante',
        'puesto_departamento',
        'direccion',
        'email',
        'telefono',
        'puntos_muestreo',
        'punto_muestreo_especificar',
        'tipos_muestra',
        'normativas',
        'normativa_especificar',
        'servicio_analisis',
        'importe',
        'referencia_bancaria',
        'razon_social',
        'rfc',
        'direccion_fiscal',
        'uso_cfdi',
        'tipo_moneda',
        'metodo_pago',
        'forma_pago',
        'ultimos_cuatro_digitos',
        'status',
        'fecha_muestreo',
        'comentarios_staff',
        'archivo_resultados',
        'archivo_factura',
        'comprobante_pago',
        'cantidad_muestras',
        'encuesta_respondida',
        'encuesta_p1',
        'encuesta_p2',
        'encuesta_p3',
        'encuesta_p4',
        'encuesta_p5',
        'encuesta_p6',
        'encuesta_p7',
        'encuesta_p8',
        'encuesta_p9',
        'encuesta_p10',
        'encuesta_promedio',
        'encuesta_mejoras',
        'encuesta_comentarios',
    ];

    protected $casts = [
        'puntos_muestreo' => 'array',
        'tipos_muestra' => 'array',
        'normativas' => 'array',
        'fecha_muestreo' => 'datetime',
        'encuesta_respondida' => 'boolean',
    ];

    /**
     * Generate a unique reference bank code for payments and tracking.
     */
    public static function generateUniqueReference()
    {
        do {
            // Generate a random code like CEAA-2026-XXXXX
            $year = date('Y');
            $random = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 5));
            $reference = "CEAA-{$year}-{$random}";
        } while (self::where('referencia_bancaria', $reference)->exists());

        return $reference;
    }
}
