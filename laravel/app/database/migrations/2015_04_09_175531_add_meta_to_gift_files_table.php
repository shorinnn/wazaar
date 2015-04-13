<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddMetaToGiftFilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('gift_files', function(Blueprint $table)
		{
			$table->text('mime')->nullable()->after('name');
			$table->text('key')->nullable()->after('name');
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
			$table->dropColumn('mime');
			$table->dropColumn('key');
		});
	}

}
