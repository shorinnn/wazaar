<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddSecondTierPublisherToUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->enum( 'is_second_tier_instructor', ['no','yes'] )->default('no')->after('affiliate_id');
			$table->enum( 'sti_approved', ['no','yes'] )->default('no')->after('is_second_tier_instructor');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->dropColumn('is_second_tier_instructor');
			$table->dropColumn('sti_approved');
		});
	}

}
