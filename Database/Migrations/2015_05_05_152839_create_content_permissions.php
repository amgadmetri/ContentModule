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
		foreach (\InstallationRepository::getModuleParts('content') as $modulePart) 
		{
			if ($modulePart->part_key === 'Contents') 
			{
				\AclRepository::insertDefaultItemPermissions(
				$modulePart->part_key, 
				$modulePart->id, 
				[
				'admin'   => ['show', 'add', 'edit', 'delete'],
				'manager' => ['show', 'edit']
				]);
			}
			else
			{
				\AclRepository::insertDefaultItemPermissions(
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
		foreach (\InstallationRepository::getModuleParts('content') as $modulePart) 
		{
			\AclRepository::deleteItemPermissions($modulePart->part_key);
		}
	}
}