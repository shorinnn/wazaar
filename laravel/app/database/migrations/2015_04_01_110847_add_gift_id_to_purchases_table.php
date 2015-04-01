<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddGiftIdToPurchasesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('purchases', function(Blueprint $table)
		{
			$table->bigInteger('gift_id')->nullable()->after('student_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('purchases', function(Blueprint $table)
		{
			$table->dropColumn('gift_id');
		});
	}

}
