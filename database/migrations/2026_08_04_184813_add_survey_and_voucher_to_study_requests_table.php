<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSurveyAndVoucherToStudyRequestsTable extends Migration
{
    public function up()
    {
        Schema::table('study_requests', function (Blueprint $table) {
            $table->string('comprobante_pago')->nullable()->after('referencia_bancaria');
            $table->integer('cantidad_muestras')->default(1)->after('direccion');
            
            // Encuesta de Satisfacción
            $table->boolean('encuesta_respondida')->default(false)->after('archivo_resultados');
            for ($i = 1; $i <= 10; $i++) {
                $table->integer("encuesta_p{$i}")->nullable()->after('encuesta_respondida');
            }
            $table->decimal('encuesta_promedio', 3, 2)->nullable()->after('encuesta_p10');
            $table->text('encuesta_mejoras')->nullable()->after('encuesta_promedio');
            $table->text('encuesta_comentarios')->nullable()->after('encuesta_mejoras');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('study_requests', function (Blueprint $table) {
            $table->dropColumn([
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
                'encuesta_comentarios'
            ]);
        });
    }
}
