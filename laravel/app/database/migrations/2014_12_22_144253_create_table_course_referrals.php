<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCourseReferrals extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('course_referrals', function ($table) {
                    $table->bigIncrements('id');
                    $table->bigInteger('student_id');
                    $table->bigInteger('affiliate_id');
                    $table->bigInteger('course_id');
                    $table->timestamp('expires');
                    $table->unique( ['student_id', 'course_id'] );
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
		Schema::drop('course_referrals');
	}

}
