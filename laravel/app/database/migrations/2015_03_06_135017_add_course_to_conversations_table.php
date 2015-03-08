<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddCourseToConversationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('conversations', function(Blueprint $table)
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
		Schema::table('conversations', function(Blueprint $table)
		{
			$table->dropColumn('course_id');
		});
	}

}
