<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffPhotoezaeazTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('azeazstaffPhoto', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('staff_photo_kind', 30);
			$table->string('image_name')->unique();
			$table->integer('id_staff_staff');
		});

		Schema::table('aeazstaffPhoto', function(Blueprint $table) {
			$table->foreign('id_staff_staff')->references('id')->on('staff')
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
		Schema::drop('staffPazeazehoto');
	}

}
