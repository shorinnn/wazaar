<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddMoreCharsToSettingsValueFieldToSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('settings', function(Blueprint $table)
		{
                    DB::statement('ALTER TABLE `settings` MODIFY COLUMN `value` TEXT ');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('settings', function(Blueprint $table)
		{
			DB::statement('ALTER TABLE `settings` MODIFY COLUMN `value` VARCHAR(255) ');
		});
	}

}
