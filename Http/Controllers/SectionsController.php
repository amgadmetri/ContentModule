<?php namespace App\Modules\Content\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Modules\Content\Http\Requests\SectionFormRequest;

class SectionsController extends BaseController {

	public function __construct()
	{
		parent::__construct('Sections');
	}

	public function getIndex()
	{
		$this->hasPermission('show');
		$sections = \CMS::sections()->all();
		
		return view('content::contentSections.viewsections', compact('sections'));
	}

	public function getCreate()
	{
		$this->hasPermission('add');
		$sections     = \CMS::sections()->all();
		$sectionTypes = \CMS::sectionTypes()->all();

		return view('content::contentSections.addsection', compact('sections', 'sectionTypes'));
	}

	public function postCreate(SectionFormRequest $request)
	{
		$this->hasPermission('add');
		\CMS::sections()->create($request->all());

		return redirect()->back()->with('message', 'Section inserted in the database succssefuly');
	}

	public function getUpdate($id)
	{
		$this->hasPermission('edit');
		$section      = \CMS::sections()->find($id);
		$sections     = \CMS::sections()->all();
		$sectionTypes = \CMS::sectionTypes()->all();

		return view('content::contentSections.updatesection', compact('section', 'sections', 'sectionTypes'));
	}

	//update the content
	public function postUpdate(SectionFormRequest $request, $id)
	{
		$this->hasPermission('edit');
		\CMS::sections()->update($id, $request->all());

		return redirect()->back()->with('message', 'Section updated succssefuly');
	}

	public function getDelete($id)
	{
		$this->hasPermission('delete');
		\CMS::sections()->delete($id);

		return redirect()->back()->with('message', 'Section Deleted succssefuly');
	}
}