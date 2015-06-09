<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddSecondTierInstructorToTransactionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('transactions', function(Blueprint $table)
		{
			DB::statement('ALTER TABLE `transactions` MODIFY COLUMN `transaction_type` 
                            ENUM("affiliate_credit","affiliate_credit_reverse","affiliate_debit","affiliate_debit_refund","cashout_fee",
                            "instructor_agency_credit","instructor_agency_credit_reverse","instructor_agency_debit","instructor_agency_debit_refund",
                            "instructor_credit","instructor_credit_reverse","instructor_debit","instructor_debit_refund",
                            "second_tier_instructor_credit","second_tier_instructor_credit_reverse","second_tier_instructor_debit","second_tier_instructor_debit_refund",
                            "site_credit", "site_credit_reverse",
                            "student_balance_debit","student_balance_debit_refund","student_credit","student_debit"
                            )');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('transactions', function(Blueprint $table)
		{
			DB::statement('ALTER TABLE `transactions` MODIFY COLUMN `transaction_type` 
                            ENUM("affiliate_credit","affiliate_credit_reverse","affiliate_debit","affiliate_debit_refund","cashout_fee",
                            "instructor_agency_credit","instructor_agency_credit_reverse","instructor_agency_debit","instructor_agency_debit_refund",
                            "instructor_credit","instructor_credit_reverse","instructor_debit","instructor_debit_refund",
                            "site_credit", "site_credit_reverse",
                            "student_balance_debit","student_balance_debit_refund","student_credit","student_debit"
                            )');
		});
	}

}
