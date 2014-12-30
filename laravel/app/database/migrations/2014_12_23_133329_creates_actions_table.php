<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatesActionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('actions', function ($table) {
                    $table->bigIncrements('id')->unsigned();
                    $table->string('type');
                    $table->string('time_after_pageload');
                    $table->string('target_class');
                    $table->string('target_id');
                    $table->string('tracker_id');
                    $table->string('url');
                    $table->string('ip');
                    $table->string('user_agent');
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
		Schema::drop('actions');
	}

}
