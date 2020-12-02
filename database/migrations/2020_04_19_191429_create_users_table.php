<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->text('email')->unique('unique_email');
			$table->text('name');
			$table->text('bio')->nullable();
			$table->text('password');
			$table->text('photo')->nullable();
			$table->date('join_date');
			$table->boolean('banned')->default(false);
		});
		
		}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
