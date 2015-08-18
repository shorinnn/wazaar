<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmailTemplatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('email_templates', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('tag');
                        $table->text('content');
			$table->timestamps();
		});
                $template =  EmailTemplate::firstOrCreate( ['tag' => 'course-approved', 'content' => '<p>&nbsp;</p>
                    <p>Hello @NAME@</p>
                    <p>&nbsp;</p>
                    <p>Your course @COURSENAME@ has been approved! @LINK@</p>'] );
                $template =  EmailTemplate::firstOrCreate( ['tag' => 'course-rejected', 'content' => '<p>Hello @NAME@</p>
                    <p>Your course @COURSENAME@ has been rejected.</p>
                    <p>Because:</p>
                    <p>@REASONS@</p>'] );
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('email_templates');
	}

}
