<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePurchasesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('purchases', function(Blueprint $table)
		{
                    $table->bigIncrements('id');
                    $table->bigInteger('product_id');
                    $table->string('product_type');
                    $table->bigInteger('student_id');
                    $table->bigInteger('ltc_affiliate_id');
                    $table->bigInteger('product_affiliate_id');
                    $table->string('tracking_code',50);
                    $table->double('purchase_price');
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
		Schema::drop('purchases');
	}

}
