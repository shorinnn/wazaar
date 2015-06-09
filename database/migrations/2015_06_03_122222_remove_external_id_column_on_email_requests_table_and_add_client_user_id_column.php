<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveExternalIdColumnOnEmailRequestsTableAndAddClientUserIdColumn extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('email_requests', function (Blueprint $table) {
            $table->dropColumn('externalUserId');
            $table->integer('userId')->after('clientId')->unsigned();

            $table->foreign('userId')->references('id')->on('client_users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('email_requests', function (Blueprint $table) {
		    $table->dropColumn('userId');
		});
	}

}
