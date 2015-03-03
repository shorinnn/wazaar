<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePrivateMessagesMassStatusesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('private_messages_mass_statuses', function(Blueprint $table)
		{
                        $table->increments('id');
			$table->bigInteger('private_message_id');
			$table->bigInteger('recipient_id');
			$table->enum('status',['read','unread']);
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
		Schema::drop('private_messages_mass_statuses');
	}

}
