<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddInstructorIdToPurchaseRefundsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('purchase_refunds', function(Blueprint $table)
		{
			$table->bigInteger('instructor_id')->after('student_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('purchase_refunds', function(Blueprint $table)
		{
			$table->dropColumn('instructor_id');
		});
	}

}
