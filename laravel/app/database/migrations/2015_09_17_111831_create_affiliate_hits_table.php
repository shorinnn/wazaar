<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAffiliateHitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('affiliate_hits', function (Blueprint $table){
		    $table->bigIncrements('id');
            $table->string('affiliate_id');
            $table->bigInteger('course_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->string('referrer')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('device')->nullable();
            $table->string('browser')->nullable();
            $table->string('operating_system')->nullable();
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
		Schema::drop('affiliate_hits');
	}

}
