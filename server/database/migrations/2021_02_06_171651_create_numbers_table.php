<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('numbers', function (Blueprint $table) {
            $table->id('num_id');
            $table->bigInteger('cnt_id')->unsigned()->index()->nullable();
            $table->foreign('cnt_id')->references('cnt_id')->on('countries')->onDelete('cascade');
            $table->integer('num_number')->default(0);;
            $table->timestamp('num_created');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('numbers');
    }
}
