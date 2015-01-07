<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoFormatsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('video_formats', function (Blueprint $table){
			$table->increments('id');
			$table->unsignedInteger('video_id');
			$table->string('output_key');
			$table->string('resolution');
			$table->integer('duration')->nullable();
			$table->string('thumbnail')->nullable();
			$table->string('video_url');

			$table->foreign('video_id')->references('id')->on('videos')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('video_formats');
	}

}
