<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id('log_id');
            $table->bigInteger('usr_id')->unsigned()->index()->nullable();
            $table->foreign('usr_id')->references('usr_id')->on('users')->onDelete('cascade');
            $table->bigInteger('num_id')->unsigned()->index()->nullable();
            $table->foreign('num_id')->references('num_id')->on('numbers')->onDelete('cascade');
            $table->string('log_message');
            $table->boolean('log_success');
            $table->timestamp('log_created');
            $table->timestamps();
        });
        $logs_routines = File::get("database/db-routines/logs.sql");
        DB::unprepared($logs_routines);//Migrate Stored Procedures
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS LOGS_GetList');
        Schema::dropIfExists('logs');
    }
}
