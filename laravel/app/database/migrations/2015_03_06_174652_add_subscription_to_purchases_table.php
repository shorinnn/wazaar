<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddSubscriptionToPurchasesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('purchases', function(Blueprint $table)
		{
			$table->timestamp('subscription_end')->nullable()->after('product_type');
                        $table->timestamp('subscription_start')->nullable()->after('product_type');
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
			$table->dropColumn('subscription_start');
			$table->dropColumn('subscription_end');
		});
	}

}
