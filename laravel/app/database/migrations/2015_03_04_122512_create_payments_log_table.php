<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('payments_log', function (Blueprint $table){
		    $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->boolean('success')->default(false);
            $table->string('reference');
            $table->text('response');
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
		Schema::drop('payments_log');
	}

}
