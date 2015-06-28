<?php namespace App\Modules\Content\Http\Controllers;

use App\Modules\Core\Http\Controllers\BaseController;
use App\Modules\Content\Http\Requests\SectionFormRequest;

class SectionsController extends BaseController {

	/**
	 * Specify a list of extra permissions.
	 * 
	 * @var permissions
	 */
	protected $permissions = [
	'getShow' => 'show', 
	];

	/**
	 * Create new SectionsController instance.
	 */
	public function __construct()
	{
		parent::__construct('Sections');
	}

	/**
	 * Display a listing of the sections.
	 * 
	 * @param  integer  $sectioTypeId
	 * @return respnonse
	 */
	public function getShow($sectioTypeId)
	{
		$sectionType = \CMS::sectionTypes()->find($sectioTypeId);
		$sections    = \CMS::sections()->findBy('section_type_id', $sectioTypeId);
		
		return view('content::sections.viewsections', compact('sections', 'sectionType'));
	}

	/**
	 * Show the form for creating a new section.
	 * 
	 * @param  integer $sectioTypeId
	 * @return response
	 */
	public function getCreate($sectioTypeId)
	{
		$parentSections = \CMS::sections()->all();
		return view('content::sections.addsection', compact('parentSections'));
	}

	/**
	 * Store a newly created section in storage.
	 * 
	 * @param  SectionFormRequest $request       
	 * @param  integer            $sectionTypeId
	 * @return response
	 */
	public function postCreate(SectionFormRequest $request, $sectionTypeId)
	{
		\CMS::sections()->create(array_merge($request->all(), ['section_type_id' => $sectionTypeId]));
		return redirect()->back()->with('message', 'Section created succssefuly');
	}

	/**
	 * Show the form for editing the specified section.
	 * 
	 * @param  integer $id
	 * @return response
	 */
	public function getEdit($id)
	{
		$section        = \CMS::sections()->find($id);
		$parentSections = \CMS::sections()->findBy('section_type_id', $section->sectionType->id);
		return view('content::sections.updatesection', compact('section', 'parentSections'));
	}

	/**
	 * Update the specified section in storage.
	 * 
	 * @param  SectionFormRequest $request
	 * @param  integer            $id
	 * @return response
	 */
	public function postEdit(SectionFormRequest $request, $id)
	{
		\CMS::sections()->update($id, $request->all());
		return redirect()->back()->with('message', 'Section updated succssefuly');
	}

	/**
	 * Remove the specified section from storage.
	 * 
	 * @param  integer $id
	 * @return response
	 */
	public function getDelete($id)
	{
		\CMS::sections()->delete($id);
		return redirect()->back()->with('message', 'Section deleted succssefuly');
	}
}