<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddRejectReasonToCoursesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('courses', function(Blueprint $table)
		{
			$table->string('reject_reason')->nullable()->after('publish_status');
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
			$table->dropColumn('reject_reason');
		});
	}

}
