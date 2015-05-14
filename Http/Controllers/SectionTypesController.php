<?php namespace App\Modules\Content\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Modules\Content\Http\Requests\SectionTypeFormRequest;

class SectionTypesController extends BaseController {

	public function __construct()
	{
		parent::__construct('SectionTypes');
	}

	public function getIndex()
	{
		$this->hasPermission('show');
		$sectionTypes = \CMS::sectionTypes()->all();
		
		return view('content::contentSectionTypes.viewsectiontypes', compact('sectionTypes'));
	}

	public function getCreate()
	{
		$this->hasPermission('add');
		return view('content::contentSectionTypes.addsectiontype');
	}

	public function postCreate(SectionTypeFormRequest $request)
	{
		$this->hasPermission('add');
		\CMS::sectionTypes()->create($request->all());

		return redirect()->back()->with('message', 'Section type inserted in the database succssefuly');
	}

	public function getUpdate($id)
	{
		$this->hasPermission('edit');
		$sectionType  = \CMS::sectionTypes()->find($id);
		$sectionTypes = \CMS::sectionTypes()->all();

		return view('content::contentSectionTypes.updatesectiontype', compact('sectionType', 'sectionTypes'));
	}

	//update the content
	public function postUpdate(SectionTypeFormRequest $request, $id)
	{
		$this->hasPermission('edit');
		\CMS::sectionTypes()->update($id, $request->all());

		return redirect()->back()->with('message', 'Section Type updated succssefuly');
	}

	public function getDelete($id)
	{
		$this->hasPermission('delete');
		\CMS::sectionTypes()->delete($id);

		return redirect()->back()->with('message', 'Section Type Deleted succssefuly');
	}
}