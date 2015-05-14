<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clients', function (Blueprint $table){
		    $table->increments('id');
            $table->string('clientName');
            $table->string('contactNumber');
            $table->string('websiteUrl');
            $table->string('apiKey');
            $table->string('accessToken');
            $table->string('encryptedAccessToken',500);
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
		Schema::drop('clients');
	}

}
