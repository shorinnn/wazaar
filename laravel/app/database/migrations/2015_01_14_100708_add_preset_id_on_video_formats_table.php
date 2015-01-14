<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPresetIdOnVideoFormatsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('video_formats', function (Blueprint $table) {
		    $table->string('preset_id')->after('output_key');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('video_formats', function (Blueprint $table) {
		    $table->dropColumn('preset_id');
		});
	}

}
