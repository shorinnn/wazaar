<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddPaymentFieldsToPurchasesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('purchases', function(Blueprint $table)
		{
			$table->double('site_earnings')->after('purchase_price')->default(0);
			$table->double('affiliate_agency_earnings')->after('purchase_price')->default(0);
			$table->double('ltc_affiliate_earnings')->after('purchase_price')->default(0);
			$table->double('affiliate_earnings')->after('purchase_price')->default(0);
			$table->double('instructor_earnings')->after('purchase_price')->default(0);
			$table->string('balance_transaction_id')->after('purchase_price')->nullable();
			$table->double('balance_used')->after('purchase_price')->default(0);
			$table->double('processor_fee')->after('purchase_price')->default(0);
			$table->string('discount')->after('purchase_price')->nullable();
			$table->double('discount_value')->after('purchase_price')->default(0);
			$table->double('original_price')->after('purchase_price')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('purchases', function(Blueprint $table)
		{
			$table->dropColumn('site_earnings');
			$table->dropColumn('affiliate_agency_earnings');
			$table->dropColumn('ltc_affiliate_earnings');
			$table->dropColumn('affiliate_earnings');
			$table->dropColumn('instructor_earnings');
			$table->dropColumn('balance_transaction_id');
			$table->dropColumn('balance_used');
			$table->dropColumn('processor_fee');
			$table->dropColumn('discount');
			$table->dropColumn('discount_value');
			$table->dropColumn('original_price');
		});
	}

}
