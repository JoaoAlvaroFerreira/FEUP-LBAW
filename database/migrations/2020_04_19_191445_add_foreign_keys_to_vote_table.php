<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToVoteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('vote', function(Blueprint $table)
		{
			$table->foreign('poll_id', 'vote_poll_id_fkey')->references('id')->on('poll')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('voter_id', 'vote_voter_id_fkey')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('vote', function(Blueprint $table)
		{
			$table->dropForeign('vote_poll_id_fkey');
			$table->dropForeign('vote_voter_id_fkey');
		});
	}

}
