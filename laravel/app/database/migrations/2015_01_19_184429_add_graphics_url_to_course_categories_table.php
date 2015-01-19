<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGraphicsUrlToCourseCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('course_categories', function(Blueprint $table)
		{
			$table->text('graphics_url');
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
			$table->dropColumn('graphics_url');
		});
	}

}
