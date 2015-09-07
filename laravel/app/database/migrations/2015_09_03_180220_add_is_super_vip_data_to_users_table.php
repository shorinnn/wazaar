<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddIsSuperVipDataToUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
                        DB::table('users')->where( 'is_vip','yes' )->update( [ 'is_super_vip' => 'yes', 'is_vip' => 'no' ] );
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
			DB::table('users')->where( 'is_super_vip','yes' )->update( [ 'is_super_vip' => 'no', 'is_vip' => 'yes' ] );
		});
	}

}
