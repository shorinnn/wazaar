<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddSizeToGiftFilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('gift_files', function(Blueprint $table)
		{
			$table->string('size')->default(0)->after('key');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('gift_files', function(Blueprint $table)
		{
			$table->dropColumn('size');
		});
	}

}
