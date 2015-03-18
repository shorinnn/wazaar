<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTransactionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transactions', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->bigInteger('user_id');
			$table->enum('transaction_type',['student_credit', 'student_balance_debit', 'student_balance_debit_refund', 'student_debit',
                            'instructor_credit', 'affiliate_credit', 'instructor_debit', 'affiliate_debit', 'site_credit', 'instructor_agency_credit',
                            'instructor_agency_debit']);
			$table->double('amount');
			$table->double('gc_fee');
			$table->bigInteger('product_id')->nullable();
			$table->string('product_type')->nullable();
			$table->string('details');
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
		Schema::drop('transactions');
	}

}
