<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVariablesToEmailRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('email_requests', function(Blueprint $table)
		{
			$table->text('bodyVariables')->after('templateId')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('email_requests', function(Blueprint $table)
		{
			$table->dropColumn('bodyVariables');
		});
	}

}
