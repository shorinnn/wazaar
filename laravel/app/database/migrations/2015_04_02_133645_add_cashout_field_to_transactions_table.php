<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddCashoutFieldToTransactionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('transactions', function(Blueprint $table)
		{
			$table->timestamp('cashed_out_on')->nullable()->after('reference');
			$table->enum( 'is_ltc',['no','yes'] )->after('transaction_type')->default('no');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('transactions', function(Blueprint $table)
		{
                    $table->dropColumn( 'cashed_out_on' );
                    $table->dropColumn( 'is_ltc' );
		});
	}

}
