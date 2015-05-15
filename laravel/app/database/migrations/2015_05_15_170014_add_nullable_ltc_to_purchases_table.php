<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddNullableLtcToPurchasesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('purchases', function(Blueprint $table)
		{
			DB::statement('ALTER TABLE `purchases` MODIFY COLUMN `ltc_affiliate_id` BIGINT(20) ');
			DB::statement('ALTER TABLE `purchase_refunds` MODIFY COLUMN `ltc_affiliate_id` BIGINT(20) ');
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
			DB::statement('ALTER TABLE `purchases` MODIFY COLUMN `ltc_affiliate_id` BIGINT(20) NOT NULL');
			DB::statement('ALTER TABLE `purchase_refunds` MODIFY COLUMN `ltc_affiliate_id` BIGINT(20) NOT NULL');
		});
	}

}
