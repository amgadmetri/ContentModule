<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentLanguagesVarsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( ! Schema::hasTable('content_languages_vars'))
		{
			Schema::create('content_languages_vars', function(Blueprint $table) {
				$table->bigIncrements('id');
				$table->string('title', 150);
				$table->string('description', 255);
				$table->text('content');
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
		if (Schema::hasTable('content_languages_vars'))
		{
			Schema::drop('content_languages_vars');
		}
	}
}