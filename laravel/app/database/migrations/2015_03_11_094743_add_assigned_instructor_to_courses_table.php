<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddAssignedInstructorToCoursesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('courses', function(Blueprint $table)
		{
			$table->enum('details_displays',['instructor','assigned_instructor'])->default('instructor')->after('instructor_id');
			$table->bigInteger('assigned_instructor')->nullable()->after('instructor_id');
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
			$table->dropColumn('assigned_instructor');
			$table->dropColumn('details_displays');
		});
	}

}
