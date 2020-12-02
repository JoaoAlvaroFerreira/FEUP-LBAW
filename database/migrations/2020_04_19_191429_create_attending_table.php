<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAttendingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('attending', function(Blueprint $table)
		{
			$table->integer('event_id');
			$table->integer('attendee_id');
			$table->primary(['event_id','attendee_id'], 'attending_pkey');
		});

	
		
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('attending');
	}

}
