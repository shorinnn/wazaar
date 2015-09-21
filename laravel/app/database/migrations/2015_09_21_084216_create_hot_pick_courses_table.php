<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotPickCoursesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('hot_pick_courses', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('course_id')->unsigned()->index();
			$table->integer('order')->unsigned();
			$table->timestamps();

			$table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('hot_pick_courses');
	}

}
