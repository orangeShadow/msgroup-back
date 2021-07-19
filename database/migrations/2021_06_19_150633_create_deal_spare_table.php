<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealSpareTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deal_spare', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deal_id')->constrained();
//            $table->foreign('deal_id')->references('id')->on('deals');
            $table->foreignId('spare_id')->constrained();
//            $table->foreign('spare_id')->references('id')->on('spares');
            $table->string('title');
            $table->unsignedDecimal('price')->default(0);
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
        Schema::dropIfExists('deal_spare');
    }
}
