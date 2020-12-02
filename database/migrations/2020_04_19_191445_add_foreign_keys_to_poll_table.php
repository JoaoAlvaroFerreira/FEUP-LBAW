<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPollTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('poll', function(Blueprint $table)
		{
			$table->foreign('event_id', 'poll_event_id_fkey')->references('id')->on('events')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('target_id', 'poll_target_id_fkey')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('poll', function(Blueprint $table)
		{
			$table->dropForeign('poll_event_id_fkey');
			$table->dropForeign('poll_target_id_fkey');
		});
	}

}
