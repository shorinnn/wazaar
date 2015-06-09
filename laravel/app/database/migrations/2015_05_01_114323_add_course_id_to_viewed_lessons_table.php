<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddCourseIdToViewedLessonsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('viewed_lessons', function(Blueprint $table)
		{
			$table->bigInteger('course_id')->after('lesson_id')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('viewed_lessons', function(Blueprint $table)
		{
			$table->dropColumn('course_id');
		});
	}

}
