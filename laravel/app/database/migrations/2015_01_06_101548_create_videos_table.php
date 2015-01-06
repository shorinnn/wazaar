<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('videos', function (Blueprint $table){
			$table->increments('id');
			$table->string('input_key');
			$table->string('output_urls');
			$table->enum('transcode_status', ['pending','completed', 'failed']);
			$table->integer('created_by_id');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
