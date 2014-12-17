<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('courses', function ($table) {
                    $table->bigIncrements('id');
                    $table->bigInteger('instructor_id');
                    $table->bigInteger('course_preview_image_id')->nullable();
                    $table->integer('course_category_id');
                    $table->integer('course_subcategory_id');
                    $table->string('name');
                    $table->string('slug')->unique();
                    $table->text('description');
                    $table->double('price', 15, 2);
                    $table->integer('featured')->default(0);
                    $table->integer('course_difficulty_id');
                    $table->integer('student_count');
                    $table->enum('privacy_status', ['private', 'public']);
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
		Schema::drop('courses');
	}

}
