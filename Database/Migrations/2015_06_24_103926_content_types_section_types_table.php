<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ContentTypesSectionTypesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( ! Schema::hasTable('content_types_section_types'))
		{
			Schema::create('content_types_section_types', function(Blueprint $table) {
				$table->bigIncrements('id');
				$table->bigInteger('content_type_id')->unsigned();
				$table->foreign('content_type_id')->references('id')->on('content_types');
				$table->bigInteger('section_type_id')->unsigned();
				$table->foreign('section_type_id')->references('id')->on('section_types');
				$table->timestamps();
			});
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		if (Schema::hasTable('content_types_section_types'))
		{
			Schema::drop('content_types_section_types');
		}
	}
}