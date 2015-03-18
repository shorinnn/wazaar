<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddInstructorAgencyToUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
                        $table->dropColumn('affiliate_agency_id');
			$table->bigInteger('instructor_agency_id')->nullable()->after('affiliate_id');
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
			$table->dropColumn('instructor_agency_id');
                        $table->integer('affiliate_agency_id')->nullable()->after('affiliate_id');
		});
	}

}
