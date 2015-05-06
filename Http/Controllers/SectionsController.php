<?php namespace App\Modules\Content\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Modules\Content\Http\Requests\SectionFormRequest;
use App\Modules\Content\Repositories\ContentRepository;

class SectionsController extends BaseController {

	public function __construct(ContentRepository $content)
	{
		parent::__construct($content, 'Sections');
	}

	public function getIndex()
	{
		$this->hasPermission('show');
		$sections = $this->repository->getAllSections();
		
		return view('content::contentSections.viewsections', compact('sections'));
	}

	public function getCreate()
	{
		$this->hasPermission('add');
		$sections     = $this->repository->getAllSections();
		$sectionTypes = $this->repository->getAllSectionTypes();

		return view('content::contentSections.addsection', compact('sections', 'sectionTypes'));
	}

	public function postCreate(SectionFormRequest $request)
	{
		$this->hasPermission('add');
		$this->repository->createSection($request->all());

		return redirect()->back()->with('message', 'Section inserted in the database succssefuly');
	}

	public function getUpdate($id)
	{
		$this->hasPermission('edit');
		$section      = $this->repository->getSection($id);
		$sections     = $this->repository->getAllSections();
		$sectionTypes = $this->repository->getAllSectionTypes();

		return view('content::contentSections.updatesection', compact('section', 'sections', 'sectionTypes'));
	}

	//update the content
	public function postUpdate(SectionFormRequest $request, $id)
	{
		$this->hasPermission('edit');
		$this->repository->updateSection($id, $request->all());

		return redirect()->back()->with('message', 'Section updated succssefuly');
	}

	public function getDelete($id)
	{
		$this->hasPermission('delete');
		$this->repository->deleteSection($id);

		return redirect()->back()->with('message', 'Section Deleted succssefuly');
	}
}