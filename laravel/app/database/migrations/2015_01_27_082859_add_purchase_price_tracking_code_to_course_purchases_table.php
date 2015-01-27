<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPurchasePriceTrackingCodeToCoursePurchasesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('course_purchases', function (Blueprint $table) {
		    $table->double('purchase_price')->after('product_affiliate_id');
			$table->string('tracking_code',50)->after('product_affiliate_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('course_purchases', function (Blueprint $table) {
			$table->dropColumn('purchase_price');
			$table->dropColumn('tracking_code');
		});
	}

}
