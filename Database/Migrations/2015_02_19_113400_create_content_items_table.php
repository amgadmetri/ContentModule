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
				$table->string('alias', 150)->index();
				$table->string('content_image', 200);
				$table->string('content_albums', 200);
				$table->enum('status', ['published', 'draft', 'suspend'])->default('draft')->index();
				$table->bigInteger('content_views')->unsigned()->default('0');
				$table->bigInteger('user_id')->unsigned();
				$table->foreign('user_id')->references('id')->on('users');
				$table->bigInteger('content_type_id')->unsigned();
				$table->foreign('content_type_id')->references('id')->on('content_types');
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
		if (Schema::hasTable('content_items'))
		{
			Schema::drop('content_items');
		}
	}
}