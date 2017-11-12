<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWashWashingRateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wash_washing_rate', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('wash_id');
			$table->unsignedSmallInteger('washing_rate_id');
			$table->integer('price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wash_washing_rate');
    }
}
