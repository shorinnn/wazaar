<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DeleteCoursePurchasesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::drop('course_purchases');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::create('course_purchases', function(Blueprint $table)
		{
                    $table->bigIncrements('id');
                    $table->bigInteger('course_id');
                    $table->bigInteger('student_id');
                    $table->bigInteger('ltc_affiliate_id');
                    $table->bigInteger('product_affiliate_id');
                    $table->string('tracking_code');
                    $table->double('purchase_price');
                    $table->timestamps();
		});
	}

}
