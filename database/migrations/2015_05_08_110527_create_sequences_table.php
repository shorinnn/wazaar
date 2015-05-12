<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSequencesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sequences', function (Blueprint $table){
		    $table->increments('id');
            $table->integer('clientId')->unsigned();
            $table->integer('sequenceGroupId')->unsigned();
            $table->string('sequenceName');
            $table->string('description');
            $table->tinyInteger('order');
            $table->string('interval');
            $table->integer('templateId')->unsigned()->nullable();
		    $table->timestamps();

            $table->foreign('clientId')->references('id')->on('clients');
            $table->foreign('sequenceGroupId')->references('id')->on('sequence_groups');
            $table->foreign('templateId')->references('id')->on('email_templates');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sequences');
	}

}
