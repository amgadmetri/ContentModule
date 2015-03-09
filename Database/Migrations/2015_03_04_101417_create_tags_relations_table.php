<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsRelationsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( ! Schema::hasTable('tags_relations'))
		{
			Schema::create('tags_relations', function(Blueprint $table) {
				$table->increments('id');
				$table->bigInteger('tag_id');
				$table->bigInteger('item_id');
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
		if (Schema::hasTable('tags_relations'))
		{
			Schema::drop('tags_relations');
		}
	}
}