<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddBalancesToUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
                        $table->double('affiliate_balance')->default(0)->after('username');
                        $table->double('instructor_balance')->default(0)->after('username');
			$table->double('student_balance')->default(0)->after('username');
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
			$table->dropColumn('student_balance');
			$table->dropColumn('instructor_balance');
			$table->dropColumn('affiliate_balance');
		});
	}

}
