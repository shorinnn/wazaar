<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMousePositionToActionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('actions', function($table)
                {
                     $table->string('ajax_url')->after('tracker_id');
                     $table->string('session_id')->after('tracker_id');
                     $table->string('window_scroll_top')->after('tracker_id');
                     $table->string('mouse_position')->after('tracker_id');
                });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('actions', function($table)
                {
                     $table->dropColumn('mouse_position');
                     $table->dropColumn('window_scroll_top');
                     $table->dropColumn('session_id');
                     $table->dropColumn('ajax_url');
                });
	}

}
