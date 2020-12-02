<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToEventImageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('event_image', function(Blueprint $table)
		{
			$table->foreign('event_id', 'event_image_event_id_fkey')->references('id')->on('events')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('event_image', function(Blueprint $table)
		{
			$table->dropForeign('event_image_event_id_fkey');
		});
	}

}
