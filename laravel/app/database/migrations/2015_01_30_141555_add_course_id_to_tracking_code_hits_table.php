<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCourseIdToTrackingCodeHitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tracking_code_hits', function (Blueprint $table) {
		    $table->integer('course_id')->after('affiliate_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tracking_code_hits', function (Blueprint $table) {
			$table->dropColumn('course_id');
		});
	}

}
