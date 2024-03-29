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
                    $table->bigInteger('course_banner_image_id')->nullable();
                    $table->integer('course_category_id');
                    $table->integer('course_subcategory_id');
                    $table->string('name');
                    $table->string('slug')->unique();
                    $table->text('description');
                    $table->text('who_is_this_for');
                    $table->text('what_will_you_achieve');
                    $table->double('price', 15, 2);
                    $table->integer('affiliate_percentage');
                    $table->integer('featured')->default(0);
                    $table->integer('course_difficulty_id');
                    $table->integer('student_count');
                    $table->enum('force_new', ['0', '1']);
                    $table->double('sale', 15, 2)->nullable();
                    $table->enum('sale_kind', ['amount', 'percentage'])->default('amount')->nullable();
                    $table->dateTime('sale_ends_on')->nullable();
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
