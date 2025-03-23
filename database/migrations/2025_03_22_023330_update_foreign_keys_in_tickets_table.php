<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeysInTicketsTable extends Migration
{
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign(['id_employe']);
            $table->dropForeign(['id_technicien']);
            $table->foreign('id_employe')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_technicien')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign(['id_employe']);
            $table->dropForeign(['id_technicien']);
            $table->foreign('id_employe')->references('id')->on('users');
            $table->foreign('id_technicien')->references('id')->on('users');
        });
    }
}
