<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() //php artisan migrate
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('project_name');
            $table->integer('no_kontrak'); //fieldId yang ada di view create
            $table->integer('no_pk');
            $table->string('uraian_kontrak');
            $table->string('rekanan');
            $table->string('pengawas');
            $table->mediumText('project_summary')->nullable();
            $table->date('start_date');
            $table->date('deadline');
            $table->longText('notes')->nullable();

            $table->integer('category_id')->unsigned()->nullable();
            $table->foreign('category_id')->references('id')->on('project_category')->onDelete('set null')->onUpdate('cascade');

            $table->integer('client_id')->unsigned()->nullable();
            $table->foreign('client_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');

            $table->mediumText('feedback')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() //php artisan migrate rollback
    {
        Schema::dropIfExists('projects');
    }

}
