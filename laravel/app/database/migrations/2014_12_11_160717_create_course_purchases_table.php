<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursePurchasesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('course_purchases', function ($table) {
                    $table->bigIncrements('id');
                    $table->bigInteger('course_id');
                    $table->bigInteger('student_id');
                    $table->bigInteger('ltc_affiliate_id');
                    $table->bigInteger('product_affiliate_id');
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
		Schema::drop('course_purchases');
	}

}
