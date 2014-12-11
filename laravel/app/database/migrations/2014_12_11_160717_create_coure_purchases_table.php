<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourePurchasesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('course_purchases', function ($table) {
                    $table->bigIncrements('id');
                    $table->bigInteger('course_id');
                    $table->bigInteger('user_id');
                    $table->bigInteger('ltc_affiliator_id');
                    $table->bigInteger('product_affiliator_id');
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
		Schema::drop('course_purchases');
	}

}
