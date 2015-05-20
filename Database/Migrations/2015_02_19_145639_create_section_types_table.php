<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionTypesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( ! Schema::hasTable('section_types'))
		{
			Schema::create('section_types', function(Blueprint $table) {
				$table->bigIncrements('id');
				$table->string('section_type_name', 255)->index();
				$table->timestamps();
			});

			\CMS::sectionTypes()->insert(
					[	
						'section_type_name' => 'category'
					]
				);
		}
	}

	/**
	 * Reverse the migration.
	 *
	 * @return void
	 */
	public function down()
	{
		if (Schema::hasTable('section_types'))
		{
			Schema::drop('section_types');
		}
	}
}