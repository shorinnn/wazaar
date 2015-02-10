<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddThumbsToTestimonialsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('testimonials', function(Blueprint $table)
		{
			$table->bigInteger('thumbs_down')->default(0)->after('reported');
			$table->bigInteger('thumbs_up')->default(0)->after('reported');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('testimonials', function(Blueprint $table)
		{
			$table->dropColumn('thumbs_down');
			$table->dropColumn('thumbs_up');
		});
	}

}
