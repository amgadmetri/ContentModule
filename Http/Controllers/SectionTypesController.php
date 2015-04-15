<?php namespace App\Modules\Content\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Content\Http\Requests\SectionTypeFormRequest;
use App\Modules\Content\Repositories\ContentRepository;

class SectionTypesController extends Controller {

	private $content;
	public function __construct(ContentRepository $content)
	{
		$this->content = $content;
		$this->middleware('AclAuthenticate');
	}

	public function getIndex()
	{
		$sectionTypes = $this->content->getAllSectionTypes();
		return view('content::contentSectionTypes.viewsectiontypes', compact('sectionTypes'));
	}

	public function getCreate()
	{
		$sectionTypes = $this->content->getAllSectionTypes();
		return view('content::contentSectionTypes.addsectiontype', compact('sectionTypes'));
	}

	public function postCreate(SectionTypeFormRequest $request)
	{
		$this->content->createSectionType($request->all());
		return redirect()->back()->with('message', 'Section type inserted in the database succssefuly');
	}

	public function getUpdate($id)
	{
		$sectionType  = $this->content->getSectionType($id);
		$sectionTypes = $this->content->getAllSectionTypes();

		return view('content::contentSectionTypes.updatesectiontype', compact('sectionType', 'sectionTypes'));
	}

	//update the content
	public function postUpdate(SectionTypeFormRequest $request, $id)
	{
		$this->content->updateSectionType($id, $request->all());
		return redirect()->back()->with('message', 'Section Type updated succssefuly');
	}

	public function getDelete($id)
	{
		$this->content->deleteSectionType($id);
		return redirect()->back()->with('message', 'Section Type Deleted succssefuly');
	}
}