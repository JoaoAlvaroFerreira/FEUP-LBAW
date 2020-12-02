<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToInvitedTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('invited', function(Blueprint $table)
		{
			$table->foreign('event_id', 'invited_event_id_fkey')->references('id')->on('events')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('invited_id', 'invited_invited_id_fkey')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('inviter_id', 'invited_inviter_id_fkey')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('invited', function(Blueprint $table)
		{
			$table->dropForeign('invited_event_id_fkey');
			$table->dropForeign('invited_invited_id_fkey');
			$table->dropForeign('invited_inviter_id_fkey');
		});
	}

}
