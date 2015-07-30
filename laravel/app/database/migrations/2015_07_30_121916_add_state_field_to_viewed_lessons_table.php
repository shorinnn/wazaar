<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddStateFieldToViewedLessonsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('viewed_lessons', function(Blueprint $table)
		{
			$table->enum('state',['started','completed'])->default('started')->after('course_id');
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
			$table->dropColumn('state');
		});
	}

}
