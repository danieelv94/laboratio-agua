<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailAndPhoneToStudyRequestsTable extends Migration
{
    public function up()
    {
        Schema::table('study_requests', function (Blueprint $table) {
            $table->string('email')->nullable();
            $table->string('telefono')->nullable();
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
            $table->dropColumn(['email', 'telefono']);
        });
    }
}
