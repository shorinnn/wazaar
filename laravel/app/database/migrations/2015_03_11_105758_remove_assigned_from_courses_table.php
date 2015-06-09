<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class RemoveAssignedFromCoursesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('courses', function(Blueprint $table)
		{
			$table->dropColumn('assigned_instructor');
                        $table->bigInteger('assigned_instructor_id')->nullable()->after('instructor_id');
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
			$table->dropColumn('assigned_instructor_id');
                        $table->bigInteger('assigned_instructor')->nullable()->after('instructor_id');
		});
	}

}
