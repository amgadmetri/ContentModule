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

				$table->bigInteger('user_id')->unsigned();
				$table->foreign('user_id')->references('id')->on('users');
				
				$table->enum('status', ['published', 'draft', 'suspend', 'deleted'])->default('draft')->index();
				$table->bigInteger('content_views')->unsigned()->default('0');
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