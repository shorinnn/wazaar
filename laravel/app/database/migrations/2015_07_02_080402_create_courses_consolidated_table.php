<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesConsolidatedTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('courses_consolidated_purchases', function (Blueprint $table){
		    $table->bigIncrements('id');
            $table->bigInteger('course_id')->nullable();
            $table->string('course_name')->nullable();
            $table->string('course_slug')->nullable();
            $table->string('course_description')->nullable();
            $table->string('course_short_description')->nullable();
            $table->double('course_price')->nullable();
            $table->string('course_free')->nullable();
            $table->integer('course_affiliate_percentage')->nullable();
            $table->integer('course_featured')->nullable();
            $table->integer('course_difficulty_id')->nullable();
            $table->integer('course_student_count')->nullable();
            $table->double('course_sale')->nullable();
            $table->string('course_sale_kind')->nullable();
            $table->dateTime('course_sale_starts_on')->nullable();
            $table->dateTime('course_sale_ends_on')->nullable();
            $table->string('course_privacy_status')->nullable();
            $table->string('course_publish_status')->nullable();
            $table->string('course_ask_teacher')->nullable();
            $table->string('course_discussions')->nullable();
            $table->string('course_show_bio')->nullable();
            $table->integer('course_total_reviews')->nullable();
            $table->integer('course_reviews_positive_score')->nullable();

            $table->bigInteger('instructor_id');
            $table->string('instructor_first_name')->nullable();
            $table->string('instructor_last_name')->nullable();
            $table->string('instructor_email')->nullable();

            $table->integer('course_category_id')->nullable();
            $table->string('course_category_name')->nullable();
            $table->string('course_category_slug')->nullable();
            $table->string('course_category_description')->nullable();
            $table->integer('course_category_courses_count')->nullable();
            $table->string('course_category_graphics_url')->nullable();
            $table->integer('course_category_color_scheme')->nullable();

            $table->integer('course_subcategory_id')->nullable();
            $table->string('course_subcategory_name')->nullable();
            $table->string('course_subcategory_slug')->nullable();
            $table->string('course_subcategory_description')->nullable();
            $table->integer('course_subcategory_courses_count')->nullable();

            $table->bigInteger('purchase_id')->nullabe();
            $table->double('purchase_price')->nullable();
            $table->double('purchase_original_price')->nullable();
            $table->double('purchase_discount_value')->nullable();
            $table->double('purchase_discount')->nullable();
            $table->dateTime('purchase_date')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('courses_consolidated_purchases');
	}

}
