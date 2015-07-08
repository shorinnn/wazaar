<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DropFrontpageVideosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::drop('frontpage_videos');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::create('frontpage_videos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('course_id');
                        $table->enum( 'type',['big','small'] )->default( 'small' );
			$table->timestamps();
		});
	}

}
