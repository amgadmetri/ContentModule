<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentSectionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( ! Schema::hasTable('content_sections'))
		{
			Schema::create('content_sections', function(Blueprint $table) {
				$table->bigIncrements('id');
				$table->bigInteger('parent_id');
				$table->string('section_name', 255);
				$table->timestamps();
				$table->boolean('is_active')->default(0);
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
		if (Schema::hasTable('content_sections'))
		{
			Schema::drop('content_sections');
		}
	}
}