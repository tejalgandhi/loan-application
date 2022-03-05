<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanApplicationsTable extends Migration
{
    public function up()
    {
        Schema::create('loan_applications', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('user_id');
            $table->decimal('loan_amount', 15, 2);
            $table->longText('description')->nullable();
            $table->enum('loan_term',['1','2'])->comment('1=>monthly,2=>weekly')->default(1);
            $table->integer('loan_months')->comment('month of loans')->nullable();
            $table->decimal('loan_amount_pay_for_month_week', 15, 2)->nullable();
            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
            $table->foreignId('status_id')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loan_applications');
    }
}
