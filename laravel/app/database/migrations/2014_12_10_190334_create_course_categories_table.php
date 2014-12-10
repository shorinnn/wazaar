<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
                Schema::create('course_categories', function ($table) {
                    $table->increments('id');
                    $table->string('name');
                    $table->string('slug')->unique();
                    $table->text('description');
                    $table->integer('courses_count');
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
		Schema::drop('course_categories');
	}

}
