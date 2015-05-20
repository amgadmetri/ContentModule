<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentsSectionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( ! Schema::hasTable('contents_sections'))
		{
			Schema::create('contents_sections', function(Blueprint $table) {
				$table->bigIncrements('id');
				$table->bigInteger('content_item_id')->unsigned();
				$table->foreign('content_item_id')->references('id')->on('content_items');
				$table->bigInteger('section_id')->unsigned();
				$table->foreign('section_id')->references('id')->on('sections');
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
		if (Schema::hasTable('contents_sections'))
		{
			Schema::drop('contents_sections');
		}
	}
}