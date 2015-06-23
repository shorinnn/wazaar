<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddPreSubmitDataToCoursesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('courses', function(Blueprint $table)
		{
			$table->text('pre_submit_data')->nullable()->after('reviews_positive_score');
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
			$table->dropColumn('pre_submit_data');
		});
	}

}
