<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePurchaseRefundsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('purchase_refunds', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->bigInteger('purchase_id')->unsigned();
			$table->bigInteger('product_id');
			$table->string('product_type');
			$table->enum('free_product', array('no','yes'))->default('no');
			$table->dateTime('subscription_start')->nullable();
			$table->dateTime('subscription_end')->nullable();
			$table->bigInteger('student_id');
			$table->bigInteger('gift_id')->nullable();
			$table->bigInteger('ltc_affiliate_id');
			$table->bigInteger('product_affiliate_id');
			$table->bigInteger('second_tier_affiliate_id')->default(0);
			$table->string('tracking_code', 50);
			$table->float('purchase_price', 10, 0);
			$table->float('original_price', 10, 0)->default(0);
			$table->float('discount_value', 10, 0)->default(0);
			$table->string('discount')->nullable();
			$table->float('processor_fee', 10, 0)->default(0);
			$table->float('tax', 10, 0)->default(0);
			$table->float('balance_used', 10, 0)->default(0);
			$table->string('balance_transaction_id')->nullable();
			$table->float('instructor_earnings', 10, 0)->default(0);
			$table->float('affiliate_earnings', 10, 0)->default(0);
			$table->float('second_tier_affiliate_earnings', 10, 0)->default(0);
			$table->float('ltc_affiliate_earnings', 10, 0)->default(0);
			$table->float('instructor_agency_earnings', 10, 0)->default(0);
			$table->float('site_earnings', 10, 0)->default(0);
			$table->string('payment_ref');
			$table->text('order_id', 65535);
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
		Schema::drop('purchase_refunds');
	}

}
