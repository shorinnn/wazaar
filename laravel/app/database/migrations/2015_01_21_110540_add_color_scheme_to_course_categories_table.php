<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColorSchemeToCourseCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('course_categories', function(Blueprint $table)
		{
			$table->string('color_scheme');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('course_categories', function(Blueprint $table)
		{
			$table->dropColumn('color_scheme');
		});
	}

}
