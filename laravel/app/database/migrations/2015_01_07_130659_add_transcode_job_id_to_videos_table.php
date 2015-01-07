<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTranscodeJobIdToVideosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('videos', function (Blueprint $table){
			$table->string('transcode_job_id')->after('input_key')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('videos', function (Blueprint $table){
			$table->dropColumn('transcode_job_id');
		});
	}

}
