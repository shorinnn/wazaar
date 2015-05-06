<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('email_requests', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('clientId')->unsigned();
            $table->integer('externalUserId')->unsigned()->nullable();
            $table->enum('requestType',['immediate','sequence']);
            $table->integer('templateId')->unsigned()->nullable();
			$table->timestamps();

            $table->foreign('clientId')->references('id')->on('clients');
            $table->foreign('templateId')->references('id')->on('email_templates');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('email_requests');
	}

}
