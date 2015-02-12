<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonPurchasesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
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

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('testimonial_ratings');
	}

}
