<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('client_users', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('clientId')->unsigned();
            $table->string('firstName');
            $table->string('lastName');
            $table->string('email');
            $table->string('groupSlug');
            $table->timestamps();

            $table->foreign('clientId')->references('id')->on('clients');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('client_users');
	}

}
