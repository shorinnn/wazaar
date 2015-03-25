<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddFreeProductToPurchasesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('purchases', function(Blueprint $table)
		{
			$table->enum('free_product',['no','yes'])->default('no')->after('product_type');
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
			$table->dropColumn('free_product');
		});
	}

}
