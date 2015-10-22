<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddPaidStatusToTransactionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('transactions', function(Blueprint $table)
		{
			DB::statement('ALTER TABLE transactions MODIFY COLUMN `status` ENUM("pending","complete","failed","paid") DEFAULT "pending"');
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
			DB::statement('ALTER TABLE transactions MODIFY COLUMN `status` ENUM("pending","complete","failed") DEFAULT "pending"');
		});
	}

}
