<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInvitedTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('invited', function(Blueprint $table)
		{
			$table->bigInteger('event_id');
			$table->bigInteger('invited_id');
			$table->bigInteger('inviter_id');
			$table->primary(['event_id','invited_id','inviter_id'], 'invited_pkey');
		});


	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('invited');
	}

}
