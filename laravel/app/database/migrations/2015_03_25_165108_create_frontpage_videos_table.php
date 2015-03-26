<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFrontpageVideosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('frontpage_videos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('course_id');
                        $table->enum( 'type',['big','small'] )->default( 'small' );
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
		Schema::drop('frontpage_videos');
	}

}
