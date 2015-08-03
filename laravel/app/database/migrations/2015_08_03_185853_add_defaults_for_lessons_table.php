<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddDefaultsForLessonsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('lessons', function(Blueprint $table)
		{
			DB::statement('ALTER TABLE lessons MODIFY COLUMN individual_sale ENUM("yes","no") DEFAULT "no"');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('lessons', function(Blueprint $table)
		{
			DB::statement('ALTER TABLE lessons MODIFY COLUMN individual_sale ENUM("yes","no") DEFAULT "yes"');
			
		});
	}

}
