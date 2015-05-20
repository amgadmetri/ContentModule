\<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentsTagsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( ! Schema::hasTable('contents_tags'))
		{
			Schema::create('contents_tags', function(Blueprint $table) {
				$table->increments('id');
				$table->bigInteger('tag_id')->unsigned();
				$table->foreign('tag_id')->references('id')->on('tags');
				$table->bigInteger('content_item_id')->unsigned();
				$table->foreign('content_item_id')->references('id')->on('content_items');
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
		if (Schema::hasTable('contents_tags'))
		{
			Schema::drop('contents_tags');
		}
	}
}