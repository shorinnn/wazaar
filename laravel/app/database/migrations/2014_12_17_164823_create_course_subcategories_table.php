<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseSubcategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
                Schema::create('course_subcategories', function ($table) {
                    $table->increments('id');
                    $table->integer('course_category_id');
                    $table->string('name');
                    $table->string('slug')->unique();
                    $table->text('description');
                    $table->bigInteger('courses_count');
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
		Schema::drop('course_subcategories');
	}

}
