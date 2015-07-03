<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddLessonDiscussionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lesson_discussions', function (Blueprint $table){
			$table->bigIncrements('id');
			$table->bigInteger('student_id');
                        $table->bigInteger('lesson_id');
                        $table->bigInteger('upvotes')->default(0);
                        $table->string('title');
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
		Schema::drop('lesson_discussions');
	}

}
