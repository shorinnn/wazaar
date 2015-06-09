<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PolymorphicFieldsForProfilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('user_profiles', function($table)
                {
                    $table->string('owner_type')->after('id');
                    $table->biginteger('owner_id')->after('id');
                    $table->dropColumn('user_id');
                    $table->dropColumn('role_id');
                    $table->timestamps();
                });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('user_profiles', function($table)
                {
                    $table->dropColumn('owner_id')->unsigned();
                    $table->dropColumn('owner_type');
                    $table->integer('role_id')->unsigned()->after('id');
                    $table->integer('user_id')->unsigned()->after('id');
                    $table->dropTimestamps();
                });
	}

}
