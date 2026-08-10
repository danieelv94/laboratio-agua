<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddArchivoFacturaToStudyRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('study_requests', function (Blueprint $table) {
            $table->string('archivo_factura')->nullable()->after('archivo_resultados');
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
            $table->dropColumn('archivo_factura');
        });
    }
}
