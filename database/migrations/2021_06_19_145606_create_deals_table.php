<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->references('id')->on('users');
            $table->foreignId('manufacturer_id')->constrained();
            $table->foreignId('device_id')->constrained();
            $table->string('serial');
            $table->string('password');
            $table->string('dev_id');
            $table->string('dev_id_password');
            $table->string('completeness');
            $table->foreignId('condition_id')->constrained();
            $table->foreignId('malfunction_id')->constrained();
            $table->unsignedBigInteger('point_a_id');
            $table->foreign('point_a_id')->references('id')->on('points');
            $table->unsignedBigInteger('point_b_id');
            $table->foreign('point_b_id')->references('id')->on('points');
            $table->unsignedBigInteger('master_id');
            $table->foreign('master_id')->references('id')->on('users');
            $table->string('video_acceptance');
            $table->string('video_diagnostics');
            $table->string('video_repair');
            $table->unsignedTinyInteger('client_mark');
            $table->text('client_comment');
            $table->unsignedTinyInteger('master_mark');
            $table->text('master_comment');
            $table->text('delay_reason');
            $table->unsignedBigInteger('cell_id')->default(0);
            $table->unsignedTinyInteger('status');
            $table->integer('hours')->nullable();
            $table->integer('price')->nullable();
//            $table->boolean('closed')->default(false);
            $table->boolean('deleted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deals');
    }
}
