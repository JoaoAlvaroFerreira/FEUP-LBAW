<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEventsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('events', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->bigInteger('owner_id');
			$table->text('event_name');
			$table->text('description');
			$table->bigInteger('price');
			$table->date('start_date');
			$table->date('end_date')->nullable();
			$table->boolean('private_event')->default(false);
			$table->string('paypal')->nullable();
			$table->text('location');
			$table->boolean('removed')->default(0);
		});

	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('events');
	}

}
