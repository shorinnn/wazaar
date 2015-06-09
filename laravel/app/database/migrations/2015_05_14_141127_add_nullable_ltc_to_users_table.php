<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddNullableLtcToUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
			DB::statement('ALTER TABLE `users` MODIFY COLUMN `ltc_affiliate_id` BIGINT(20) ');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table)
		{
			DB::statement('ALTER TABLE `users` MODIFY COLUMN `ltc_affiliate_id` BIGINT(20) NOT NULL ');
		});
	}

}
