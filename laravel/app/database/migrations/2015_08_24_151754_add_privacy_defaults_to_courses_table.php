<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddPrivacyDefaultsToCoursesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('courses', function(Blueprint $table)
		{
			DB::statement('ALTER TABLE `courses` MODIFY COLUMN `privacy_status` ENUM("private","public") DEFAULT "public"');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('courses', function(Blueprint $table)
		{
			DB::statement('ALTER TABLE `courses` MODIFY COLUMN `privacy_status` ENUM("private","public") DEFAULT "private"');
		});
	}

}
