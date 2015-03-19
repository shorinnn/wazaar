<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddInstructorReadToConversationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('conversations', function(Blueprint $table)
		{
			$table->enum( 'instructor_read', ['yes','no'] )->default('no')->after('content');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('conversations', function(Blueprint $table)
		{
			$table->dropColumn('instructor_read');
		});
	}

}
