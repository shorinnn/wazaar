<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCourseAffiliateCustomPercentagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('course_affiliate_custom_percentages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('course_id');
                        $table->bigInteger('affiliate_id');
                        $table->integer('percentage');
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
		Schema::drop('course_affiliate_custom_percentages');
	}

}
