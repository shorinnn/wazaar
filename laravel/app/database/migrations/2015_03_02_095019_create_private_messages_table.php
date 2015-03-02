<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePrivateMessagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('private_messages', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->bigInteger('sender_id');
			$table->bigInteger('recipient_id')->nullable();
			$table->bigInteger('reply_to')->nullable();
			$table->bigInteger('thread_id');
			$table->enum('type',['ask_teacher','mass_message','student_conversation'] );
			$table->bigInteger('course_id');
			$table->bigInteger('lesson_id');
			$table->text('content');
			$table->enum('status', ['unread', 'read'])->default('unread');
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
		Schema::drop('private_messages');
	}

}
