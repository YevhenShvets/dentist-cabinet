<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDentistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dentist', function (Blueprint $table) {
            $table->unsignedBigInteger('dentist_id');
            $table->unsignedBigInteger('clinic_id');
            $table->binary('photo')->nullable();

            $table->foreign('dentist_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dentist');
    }
}
