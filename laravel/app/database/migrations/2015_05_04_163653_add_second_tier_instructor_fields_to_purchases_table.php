<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddSecondTierInstructorFieldsToPurchasesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('purchases', function(Blueprint $table)
		{
			$table->bigInteger('second_tier_instructor_id')->after('second_tier_affiliate_id')->default(0);
			$table->double('second_tier_instructor_earnings')->after('instructor_earnings')->default(0);
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
			$table->dropColumn('second_tier_instructor_id');
			$table->dropColumn('second_tier_instructor_earnings');
		});
	}

}
