<?php namespace App\Modules\Content\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Modules\Content\Http\Requests\SectionTypeFormRequest;
use App\Modules\Content\Repositories\ContentRepository;

class SectionTypesController extends BaseController {

	public function __construct(ContentRepository $content)
	{
		parent::__construct($content, 'SectionTypes');
	}

	public function getIndex()
	{
		$this->hasPermission('show');
		$sectionTypes = $this->repository->getAllSectionTypes();
		
		return view('content::contentSectionTypes.viewsectiontypes', compact('sectionTypes'));
	}

	public function getCreate()
	{
		$this->hasPermission('add');
		$sectionTypes = $this->repository->getAllSectionTypes();

		return view('content::contentSectionTypes.addsectiontype', compact('sectionTypes'));
	}

	public function postCreate(SectionTypeFormRequest $request)
	{
		$this->hasPermission('add');
		$this->repository->createSectionType($request->all());

		return redirect()->back()->with('message', 'Section type inserted in the database succssefuly');
	}

	public function getUpdate($id)
	{
		$this->hasPermission('edit');
		$sectionType  = $this->repository->getSectionType($id);
		$sectionTypes = $this->repository->getAllSectionTypes();

		return view('content::contentSectionTypes.updatesectiontype', compact('sectionType', 'sectionTypes'));
	}

	//update the content
	public function postUpdate(SectionTypeFormRequest $request, $id)
	{
		$this->hasPermission('edit');
		$this->repository->updateSectionType($id, $request->all());

		return redirect()->back()->with('message', 'Section Type updated succssefuly');
	}

	public function getDelete($id)
	{
		$this->hasPermission('delete');
		$this->repository->deleteSectionType($id);

		return redirect()->back()->with('message', 'Section Type Deleted succssefuly');
	}
}