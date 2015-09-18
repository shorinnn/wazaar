<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddCourseIdToLessonDiscussionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('lesson_discussions', function(Blueprint $table)
		{
			$table->bigInteger('course_id')->after('lesson_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('lesson_discussions', function(Blueprint $table)
		{
			$table->dropColumn('course_id');
		});
	}

}
