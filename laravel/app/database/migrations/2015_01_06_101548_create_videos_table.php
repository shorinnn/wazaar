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
			$table->increments('id')->unsigned();
			$table->string('original_filename');
			$table->string('input_key')->nullable();
			$table->enum('transcode_status', [Video::STATUS_SUBMITTED,Video::STATUS_PROGRESSING, Video::STATUS_COMPLETE, Video::STATUS_ERROR, Video::STATUS_CANCELED])->nullable();
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
		Schema::drop('videos');
	}

}
