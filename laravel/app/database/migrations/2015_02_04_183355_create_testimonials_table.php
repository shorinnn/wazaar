<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestimonialsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('testimonials', function (Blueprint $table){
		    $table->bigIncrements('id')->unsigned();
                    $table->bigInteger('course_id');
                    $table->bigInteger('student_id');
                    $table->text('content');
                    $table->enum('rating', ['positive','negative']);
                    $table->enum('reported', ['no','yes']);
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
		Schema::drop('testimonials');
	}

}
