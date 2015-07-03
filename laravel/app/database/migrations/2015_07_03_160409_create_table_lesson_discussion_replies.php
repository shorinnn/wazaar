<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTableLessonDiscussionReplies extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lesson_discussion_replies', function(Blueprint $table)
		{
			$table->increments('id');
                        $table->bigInteger('lesson_discussion_id');
                        $table->bigInteger('student_id');
                        $table->bigInteger('upvotes')->default(0);
                        $table->text('content');
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
		Schema::drop('lesson_discussion_replies');
	}

}
