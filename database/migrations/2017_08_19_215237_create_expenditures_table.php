<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpendituresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenditures', function (Blueprint $table) {
            $table->increments('id');
			$table->enum('type', ['Listrik', 'Shampoo & Keperluan Salon', 'Lain-lain']);
			$table->string('description');
			$table->integer('price');
			$table->unsignedInteger('user_id');
            $table->timestamp('creation_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenditures');
    }
}
