<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddFinancialFieldsToUserProfilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('user_profiles', function(Blueprint $table)
		{
			$table->string('bank_code')->after('social_confirmation')->nullable();
			$table->string('bank_name')->after('bank_code')->nullable();
			$table->string('branch_code')->after('bank_name')->nullable();
			$table->string('branch_name')->after('branch_code')->nullable();
			$table->string('account_type')->after('branch_name')->nullable();
			$table->string('account_number')->after('account_type')->nullable();
			$table->string('beneficiary_name')->after('account_number')->nullable();
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
			$table->dropColumn('bank_code');
			$table->dropColumn('bank_name');
			$table->dropColumn('branch_code');
			$table->dropColumn('branch_name');
			$table->dropColumn('account_type');
			$table->dropColumn('account_number');
			$table->dropColumn('beneficiary_name');
		});
	}

}
