<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentItemsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( ! Schema::hasTable('content_items'))
		{
			Schema::create('content_items', function(Blueprint $table) {
				$table->bigIncrements('id');;
				$table->string('alias', 150);
				$table->string('post_image', 100);
				$table->timestamps();
				$table->bigInteger('user_id');
				$table->enum('status', ['published', 'draft', 'suspend', 'deleted'])->default('draft');
				$table->bigInteger('post_views')->default('0');

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
		if (Schema::hasTable('content_items'))
		{
			Schema::drop('content_items');
		}
	}
}