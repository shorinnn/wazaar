<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumsToUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function($table)
                {
                    $table->string('facebook_login_id')->nullable();
                    $table->string('google_plus_login_id')->nullable();
                    $table->string('first_name')->nullable();
                    $table->string('last_name')->nullable();
                    $table->text('bio')->nullable();
                    $table->string('photo')->nullable();
                    $table->text('address_1')->nullable();
                    $table->text('address_2')->nullable();
                    $table->string('prefecture')->nullable();
                    $table->string('zip_code')->nullable();
                    $table->string('custom_site_link')->nullable();
                    $table->string('google_plus_profile_id')->nullable();
                    $table->string('twitter_profile_id')->nullable();
                    $table->string('facebook_profile_id')->nullable();
                    $table->string('linkedin_profile_id')->nullable();
                    $table->string('youtube_profile_id')->nullable();
                });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function($table)
                {
                    $table->dropColumn('facebook_login_id');
                    $table->dropColumn('google_plus_login_id');
                    $table->dropColumn('first_name');
                    $table->dropColumn('last_name');
                    $table->dropColumn('bio');
                    $table->dropColumn('photo');
                    $table->dropColumn('address_1');
                    $table->dropColumn('address_2');
                    $table->dropColumn('prefecture');
                    $table->dropColumn('zip_code');
                    $table->dropColumn('custom_site_link');
                    $table->dropColumn('google_plus_profile_id');
                    $table->dropColumn('twitter_profile_id');
                    $table->dropColumn('facebook_profile_id');
                    $table->dropColumn('linkedin_profile_id');
                    $table->dropColumn('youtube_profile_id');
                });
	}

}
