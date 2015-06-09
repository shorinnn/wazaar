<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddInstructorAgencyToPurchasesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('purchases', function(Blueprint $table)
		{
			$table->double('instructor_agency_earnings')->default(0)->after('affiliate_agency_earnings');
			$table->dropColumn('affiliate_agency_earnings');
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
                        $table->double('affiliate_agency_earnings')->default(0)->after('instructor_agency_earnings');
                    	$table->dropColumn('instructor_agency_earnings');
		});
	}

}
