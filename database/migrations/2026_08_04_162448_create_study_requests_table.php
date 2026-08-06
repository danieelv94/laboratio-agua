<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudyRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('study_requests', function (Blueprint $table) {
            $table->id();
            
            // Datos del Solicitante
            $table->string('solicitante');
            $table->string('representante');
            $table->string('puesto_departamento');
            $table->text('direccion');
            
            // Datos de la Muestra
            $table->text('puntos_muestreo'); // Store JSON/Array
            $table->string('punto_muestreo_especificar')->nullable();
            $table->text('tipos_muestra'); // Store JSON/Array
            $table->text('normativas'); // Store JSON/Array
            $table->string('normativa_especificar')->nullable();
            
            // Cuota de Recuperación (Información de la CEAA)
            $table->string('servicio_analisis')->default('Análisis fisicoquímico bacteriológico de agua (Con toma de muestra)');
            $table->decimal('importe', 10, 2)->default(7698.02);
            $table->string('referencia_bancaria')->unique();
            
            // Información de Facturación (Opcional)
            $table->string('razon_social')->nullable();
            $table->string('rfc')->nullable();
            $table->text('direccion_fiscal')->nullable();
            $table->string('uso_cfdi')->nullable();
            $table->string('tipo_moneda')->default('MXN');
            $table->string('metodo_pago')->nullable();
            $table->string('forma_pago')->nullable();
            $table->string('ultimos_cuatro_digitos')->nullable();
            
            // Estado y Control CEAA
            $table->string('status')->default('pendiente'); // pendiente, pago_verificado, muestreo_programado, en_analisis, completado, rechazado
            $table->dateTime('fecha_muestreo')->nullable();
            $table->text('comentarios_staff')->nullable();
            $table->string('archivo_resultados')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('study_requests');
    }
}
