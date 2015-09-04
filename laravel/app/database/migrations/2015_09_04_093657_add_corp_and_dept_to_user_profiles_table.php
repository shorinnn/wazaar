<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddCorpAndDeptToUserProfilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('user_profiles', function(Blueprint $table)
		{
			$table->string('department')->after('last_name')->nullable();
			$table->string('corporation_name')->after('last_name')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('user_profiles', function(Blueprint $table)
		{
			$table->dropColumn('department');
			$table->dropColumn('corporation_name');
		});
	}

}
