<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealMalfunctionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deal_malfunction', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deal_id')->constrained();
            $table->foreignId('malfunction_id')->constrained();
            $table->string('title');
            $table->unsignedInteger('hours')->default(0);
            $table->unsignedDecimal('price')->default(0);
            $table->boolean('active')->default(true);
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
        Schema::dropIfExists('deal_malfunctions');
    }
}
