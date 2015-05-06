<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailTemplatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('email_templates', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('clientId')->unsigned();
            $table->string('templateName');
            $table->string('slug');
            $table->string('subject');
            $table->string('fromAddress');
            $table->string('fromName');
            $table->text('body');
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
		Schema::drop('email_templates');
	}

}
