<?php namespace App\Modules\Content\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Content\Http\Requests\SectionFormRequest;
use App\Modules\Content\Repositories\ContentRepository;

class SectionsController extends Controller {

	private $content;
	public function __construct(ContentRepository $content)
	{
		$this->content = $content;
		$this->middleware('AclAuthenticate');
	}

	public function getIndex()
	{
		$sections = $this->content->getAllSections();
		return view('content::contentSections.viewsections', compact('sections'));
	}

	public function getCreate()
	{
		$sections = $this->content->getAllSections();
		return view('content::contentSections.addsection', compact('sections'));
	}

	public function postCreate(SectionFormRequest $request)
	{
		$this->content->createSection($request->all());
		return redirect()->back()->with('message', 'Section inserted in the database succssefuly');
	}

	public function getUpdate($id)
	{
		$section  = $this->content->getSection($id);
		$sections = $this->content->getAllSections();

		return view('content::contentSections.updatesection', compact('section', 'sections'));
	}

	//update the content
	public function postUpdate(SectionFormRequest $request, $id)
	{
		$this->content->updateSection($id, $request->all());
		return redirect()->back()->with('message', 'Section updated succssefuly');
	}

	public function getDelete($id)
	{
		$this->content->deleteSection($id);
		return redirect()->back()->with('message', 'Section Deleted succssefuly');
	}
}