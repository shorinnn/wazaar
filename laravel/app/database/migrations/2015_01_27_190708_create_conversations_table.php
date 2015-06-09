<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConversationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('conversations', function(Blueprint $table)
		{
                    $table->bigIncrements('id')->unsigned();
                    $table->bigInteger('lesson_id')->nullable();
                    $table->bigInteger('poster_id');
                    $table->bigInteger('reply_to')->nullable();
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
		Schema::drop('conversations');
	}

}
