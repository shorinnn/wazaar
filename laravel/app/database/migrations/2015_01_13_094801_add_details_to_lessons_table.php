<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDetailsToLessonsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('lessons', function(Blueprint $table)
		{
			$table->text('description');
			$table->double('price', 15, 2);
			$table->enum('published', ['no','yes']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('lessons', function(Blueprint $table)
		{
			$table->dropColumn('description');
			$table->dropColumn('price');
			$table->dropColumn('published');
		});
	}

}
