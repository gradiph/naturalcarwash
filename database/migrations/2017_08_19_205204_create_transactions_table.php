<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->unsignedInteger('user_id');
			$table->enum('type', ['Umum', 'Karyawan']);
			$table->string('worker_description')->nullable();
            $table->timestamp('creation_date');
			$table->enum('status', ['1', '0']);
			$table->string('cancel_reason')->nullable();
			$table->integer('wash_total')->default(0);
			$table->integer('nonwash_total')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
