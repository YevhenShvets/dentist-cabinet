<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('record', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id');
            $table->unsignedBigInteger('dentist_id');
            $table->dateTime('date_record');
            $table->boolean('active');
            $table->dateTime('date_first');
            $table->foreign('dentist_id')->references('dentist_id')->on('dentist')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('person_id')->references('person_id')->on('person')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('record');
    }
}
