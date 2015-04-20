<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddCourseRequirementsToCoursesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('courses', function(Blueprint $table)
		{
			$table->text('requirements')->nullable()->after('what_will_you_achieve');
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
			$table->dropColumn('requirements');
		});
	}

}
