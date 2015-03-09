<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentRelationsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( ! Schema::hasTable('content_relations'))
		{
			Schema::create('content_relations', function(Blueprint $table) {
				$table->bigIncrements('id');
				$table->bigInteger('item_id');
				$table->bigInteger('section_id');
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
		if (Schema::hasTable('content_relations'))
		{
			Schema::drop('content_relations');
		}
	}
}