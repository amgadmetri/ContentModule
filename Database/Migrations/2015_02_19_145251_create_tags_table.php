<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( ! Schema::hasTable('tags'))
		{
			Schema::create('tags', function(Blueprint $table) {
				$table->bigIncrements('id');
				$table->string('tag_name', 255)->index();
				$table->timestamps();
			});
		}
	}

	/**
	 * Reverse the migration.
	 *
	 * @return void
	 */
	public function down()
	{
		if (Schema::hasTable('tags'))
		{
			Schema::drop('tags');
		}
	}
}