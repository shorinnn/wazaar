<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLessonDiscussionReplyRatings extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lesson_discussion_reply_ratings', function(Blueprint $table)
		{
			$table->increments('id');
                        $table->bigInteger('lesson_discussion_reply_id');
                        $table->bigInteger('student_id');
                        $table->enum('vote', ['up','down']);
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
		Schema::drop('lesson_discussion_reply_ratings');
	}

}
