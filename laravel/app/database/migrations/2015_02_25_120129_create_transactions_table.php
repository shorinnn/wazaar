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
			$table->enum('transaction_type',[ 
                            'student_credit', 
                            'student_balance_debit', 
                            'student_balance_debit_refund', 
                            'student_debit',
                            'instructor_credit', 
                            'instructor_credit_reverse', 
                            'instructor_debit', 
                            'instructor_debit_refund', 
                            'affiliate_credit_reverse', 
                            'affiliate_credit', 
                            'affiliate_debit', 
                            'affiliate_debit_refund', 
                            'site_credit', 
                            'site_credit_reverse', 
                            'instructor_agency_credit_reverse',
                            'instructor_agency_credit',
                            'instructor_agency_debit', 
                            'instructor_agency_debit_refund', 
                            'cashout_fee' ]);
			$table->double('amount');
			$table->double('gc_fee');
			$table->bigInteger('product_id')->nullable();
			$table->string('product_type')->nullable();
			$table->string('details');
			$table->bigInteger('purchase_id')->nullable();
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
