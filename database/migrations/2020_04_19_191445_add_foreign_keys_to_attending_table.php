<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAttendingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('attending', function(Blueprint $table)
		{
			$table->foreign('event_id', 'attending_event_id_fkey')->references('id')->on('events')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('attendee_id', 'attending_attendee_id_fkey')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('attending', function(Blueprint $table)
		{
			$table->dropForeign('attending_event_id_fkey');
			$table->dropForeign('attending_attendee_id_fkey');
		});
	}

}
