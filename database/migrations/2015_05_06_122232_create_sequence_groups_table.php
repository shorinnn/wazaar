<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSequenceGroupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sequence_groups', function (Blueprint $table){
            $table->increments('id');
            $table->string('groupName');
            $table->integer('clientId')->unsigned();
            $table->timestamps();

            $table->foreign('clientId')->references('id')->on('clients');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sequence_groups');
	}

}
