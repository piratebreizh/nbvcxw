<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('staff', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('staff_last_name', 60);
			$table->string('staff_first_name', 60);
			$table->string('staff_first_email', 60);
			$table->string('contract_number', 60);
			$table->string('staff_phone', 60);
			$table->boolean('valid')->default(false);
			$table->integer('id_users')->unsigned();
			$table->timestamps();
			$table->rememberToken();			
		});

		Schema::table('staff', function(Blueprint $table) {
			$table->foreign('id_users')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('staff');
	}

}