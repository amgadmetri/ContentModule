<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( ! Schema::hasTable('sections'))
		{
			Schema::create('sections', function(Blueprint $table) {
				$table->bigIncrements('id');
				$table->bigInteger('parent_id');
				$table->string('section_name', 255)->index();
				$table->bigInteger('section_image');
				$table->boolean('is_active')->default(0);
				$table->bigInteger('section_type_id')->unsigned();
				$table->foreign('section_type_id')->references('id')->on('section_types');
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
		if (Schema::hasTable('sections'))
		{
			Schema::drop('sections');
		}
	}
}