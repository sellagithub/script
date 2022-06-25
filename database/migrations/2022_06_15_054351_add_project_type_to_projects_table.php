<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProjectTypeToProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            //
            $table->integer('project_type');
            $table->integer('pos_anggaran');
            $table->integer('rekanan');
            $table->integer('unit_wilayah');
            $table->integer('status_proyek');
            $table->integer('pengawas');
            $table->integer('direksi_pengawas');
           

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            //
            $table->dropColumn('project_type');
            $table->dropColumn('pos_anggaran');
            $table->dropColumn('rekanan');
            $table->dropColumn('unit_wilayah');
            $table->dropColumn('status_proyek');
            $table->dropColumn('pengawas');
            $table->dropColumn('direksi_pengawas');            
        });
    }
}
