<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailHistoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('email_history', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('emailRequestId')->unsigned();
            $table->string('mandrillReferenceId');
            $table->string('mandrillStatus');
            $table->string('mandrillRejectReason')->nullable();
			$table->timestamps();

            $table->foreign('emailRequestId')->references('id')->on('email_requests');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('email_history');
	}

}
