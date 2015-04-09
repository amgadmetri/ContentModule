<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentTagsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( ! Schema::hasTable('content_tags'))
		{
			Schema::create('content_tags', function(Blueprint $table) {
				$table->bigIncrements('id');
				$table->string('tag_content', 255)->index();
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
		if (Schema::hasTable('content_tags'))
		{
			Schema::drop('content_tags');
		}
	}
}