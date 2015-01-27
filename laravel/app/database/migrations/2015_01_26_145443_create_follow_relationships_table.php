<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFollowRelationshipsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('follow_relationships', function(Blueprint $table)
		{
                    $table->bigIncrements('id')->unsigned();
                    $table->bigInteger('instructor_id');
                    $table->bigInteger('student_id');
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
		Schema::drop('follow_relationships');
	}

}
