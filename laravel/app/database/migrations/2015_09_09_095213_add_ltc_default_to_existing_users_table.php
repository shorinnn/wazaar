<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddLtcDefaultToExistingUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('existing_users', function(Blueprint $table)
		{
                    DB::table('users')->where('affiliate_id', '>','0')->update( [ 'has_ltc' => 'yes' ] );
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('existing_users', function(Blueprint $table)
		{
                    DB::table('users')->where('affiliate_id', '>','0')->update( [ 'has_ltc' => 'yes' ] );
		});
	}

}
