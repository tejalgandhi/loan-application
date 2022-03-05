<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateLoanHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_histories', function (Blueprint $table) {
            $table->string('id');
            $table->string('loan_id')->index();
            $table->integer('duration')->nullable();
            $table->double('amount_paid')->default(4, 7);
            $table->datetime('paid_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->double('remaining_balance')->default(4, 7);
            $table->string('payment_method')->nullable();
            $table->string('bank_name')->nullable();
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
        Schema::dropIfExists('loan_histories');
    }
}
