<?php namespace App\Modules\Content\Facades;

use Illuminate\Support\Facades\Facade;

class ContentRepository extends Facade
{
	protected static function getFacadeAccessor() { return 'ContentRepository'; }
}