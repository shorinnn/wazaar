<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProfilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_profiles', function (Blueprint $table){
			$table->engine ='InnoDB';

		    $table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('role_id')->unsigned();
			$table->string('first_name');
			$table->string('last_name');
			$table->string('email');
			$table->text('bio');
			$table->string('photo');
			$table->string('address_1');
			$table->string('address_2');
			$table->string('prefecture');
			$table->string('city');
			$table->string('zip');
			$table->string('website');
			$table->string('google_plus');
			$table->string('facebook');
			$table->string('twitter');
			$table->string('linked_in');
			$table->string('youtube');
			$table->string('social_confirmation');



		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_profiles');
	}

}
