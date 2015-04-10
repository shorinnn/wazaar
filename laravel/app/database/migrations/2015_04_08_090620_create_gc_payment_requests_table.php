<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGcPaymentRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('gc_payment_requests', function (Blueprint $table){
		    $table->increments('id');
            $table->string('wazaar_reference')->index();
            $table->string('gc_form_action');
            $table->string('gc_form_method');
            $table->string('gc_order_id');
            $table->string('gc_reference');
            $table->string('gc_mac');
            $table->string('gc_return_mac');
            $table->integer('gc_status_id');
            $table->boolean('is_processed');
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
		Schema::drop('gc_payment_requests');
	}

}
