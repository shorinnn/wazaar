<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DeleteLessonPurchasesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::drop('lesson_purchases');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::create('lesson_purchases', function(Blueprint $table)
		{
                    $table->bigIncrements('id');
                    $table->bigInteger('lesson_id');
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
