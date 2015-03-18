<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddBalanceToInstructorAgenciesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('instructor_agencies', function(Blueprint $table)
		{
			$table->double('balance')->default(0)->after('name');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('instructor_agencies', function(Blueprint $table)
		{
			$table->dropColumn('balance');
		});
	}

}
