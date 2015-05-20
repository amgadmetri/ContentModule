<?php namespace App\Modules\Content\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Modules\Content\Http\Requests\SectionTypeFormRequest;

class SectionTypesController extends BaseController {

	/**
	 * Create new SectionTypesController instance.
	 */
	public function __construct()
	{
		parent::__construct('SectionTypes');
	}

	/**
	 * Display a listing of the section types.
	 * 
	 * @return respnonse
	 */
	public function getIndex()
	{
		$sectionTypes = \CMS::sectionTypes()->all();
		return view('content::sectiontypes.viewsectiontypes', compact('sectionTypes'));
	}

	/**
	 * Show the form for creating a new section type.
	 * 
	 * @return response
	 */
	public function getCreate()
	{
		return view('content::sectiontypes.addsectiontype');
	}

	/**
	 * Store a newly created section type in storage.
	 * 
	 * @param  SectionTypeFormRequest $request
	 * @return response
	 */
	public function postCreate(SectionTypeFormRequest $request)
	{
		\CMS::sectionTypes()->create($request->all());
		return redirect()->back()->with('message', 'Section Type created succssefuly');
	}

	/**
	 * Show the form for editing the specified section type.
	 * 
	 * @param  integer $id
	 * @return response
	 */
	public function getEdit($id)
	{
		$sectionType = \CMS::sectionTypes()->find($id);
		return view('content::sectiontypes.updatesectiontype', compact('sectionType'));
	}

	/**
	 * Update the specified section type in storage.
	 * 
	 * @param  SectionTypeFormRequest $request
	 * @param  integer                $id
	 * @return response
	 */
	public function postEdit(SectionTypeFormRequest $request, $id)
	{
		\CMS::sectionTypes()->update($id, $request->all());
		return redirect()->back()->with('message', 'Section Type updated succssefuly');
	}

	/**
	 * Remove the specified section type from storage.
	 * 
	 * @param  integer $id
	 * @return response
	 */
	public function getDelete($id)
	{
		\CMS::sectionTypes()->delete($id);
		return redirect()->back()->with('message', 'Section Type Deleted succssefuly');
	}
}