<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentPermissions extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		foreach (\CMS::CoreModuleParts()->getModuleParts('content') as $modulePart) 
		{
			if ($modulePart->part_key === 'Contents') 
			{
				\CMS::permissions()->insertDefaultItemPermissions(
				                     $modulePart->part_key, 
				                     $modulePart->id, 
				                     [
					                     'admin'   => ['show', 'add', 'edit', 'delete'],
					                     'manager' => ['show', 'edit']
				                     ]);
			}
			else
			{
				\CMS::permissions()->insertDefaultItemPermissions(
				                     $modulePart->part_key, 
				                     $modulePart->id, 
				                     [
					                     'admin'   => ['show', 'add', 'edit', 'delete'],
					                     'manager' => ['show', 'edit']
				                     ]);
			}
		}
	}

	/**
	 * Reverse the migration.
	 *
	 * @return void
	 */
	public function down()
	{
		foreach (\CMS::CoreModuleParts()->getModuleParts('content') as $modulePart) 
		{
			\CMS::permissions()->deleteItemPermissions($modulePart->part_key);
		}
	}
}