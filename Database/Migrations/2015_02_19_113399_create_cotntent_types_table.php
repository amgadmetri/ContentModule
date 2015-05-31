<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotntentTypesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( ! Schema::hasTable('content_types'))
		{
			Schema::create('content_types', function(Blueprint $table) {
				$table->bigIncrements('id');
				$table->string('content_type_name', 255)->index();
				$table->string('theme', 255)->index();
				$table->timestamps();
			});
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		if (Schema::hasTable('content_types'))
		{
			Schema::drop('content_types');
		}
	}
}