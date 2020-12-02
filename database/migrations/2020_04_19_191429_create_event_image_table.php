<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEventImageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('event_image', function(Blueprint $table)
		{
			$table->bigInteger('event_id');
			$table->text('image_url');
			$table->primary(['event_id','image_url'], 'event_image_pkey');
		});

	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('event_image');
	}

}
