<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTableDiscussionRatings extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lesson_discussion_ratings', function(Blueprint $table)
		{
			$table->bigIncrements('id')->unsigned();
                        $table->bigInteger('lesson_discussion_id');
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
		Schema::drop('lesson_discussion_ratings');
	}

}
