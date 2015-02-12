<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestimonialRatingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('testimonial_ratings', function (Blueprint $table){
		    $table->bigIncrements('id')->unsigned();
                    $table->bigInteger('testimonial_id');
                    $table->bigInteger('student_id');
                    $table->enum('rating', ['positive','negative']);
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
		Schema::drop('testimonial_ratings');
	}

}
