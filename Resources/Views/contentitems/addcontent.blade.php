@extends('core::app')
@section('content')

<div class="container">
  <div class="col-sm-8">
    @if (count($errors) > 0)
      <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @if (Session::has('message'))
      <div class="alert alert-success">
        <ul>
          <li>{{ Session::get('message') }}</li>
        </ul>
      </div>
    @endif
    
    <div class="col-sm-12">
      <div class="col-sm-6">
       <div class="form-group">
        <label for="content_image">Image</label>
        <img class="img-responsive" src="http://placehold.it/200x200" width="200" height="200" id="content_image">
        <br>
        {!! $contentImageMediaLibrary !!}
       </div>
      </div>
    </div>

    <form method="post" id="content_form">  
      <input name="_token" type="hidden" value="{{ csrf_token() }}">
      <input type  ="hidden" name  ="content_image">

      <div class="form-group">
        <label for="alias">Alias</label>
        <input 
        type             ="text" 
        class            ="form-control" 
        name             ="alias" 
        value            ="{{ old('alias') }}" 
        placeholder      ="Add alias here .." 
        aria-describedby ="sizing-addon2"
        >
      </div>

      <div class="form-group">
        <label for="status">Status</label>
        <select name="status" class="form-control">
          <option @if(old('status') === "published") selected @endif value="published">Published</option>
          <option @if(old('status') === "draft") selected @endif value="draft">Draft</option>
          <option @if(old('status') === "suspend") selected @endif value="suspend">Suspend</option>
        </select>  
      </div>

      <div class="form-group">
        <label for="title">Title</label>
        <input 
        type             ="text" 
        class            ="form-control" 
        name             ="title" 
        value            ="{{ old('title') }}" 
        placeholder      ="Add title here .." 
        aria-describedby ="sizing-addon2"
        >
      </div>

      <div class="form-group">
        <label for="description">Description</label>
        <input 
        type             ="text" 
        class            ="form-control" 
        name             ="description" 
        value            ="{{ old('description') }}" 
        placeholder      ="Description .." 
        aria-describedby ="sizing-addon2"
        >
      </div>

      <div class="form-group">
        <label for="content">Content</label>
        <textarea 
        class            ="form-control" 
        rows             ="3" name="content" 
        value            ="{{ old('content') }}" 
        placeholder      ="Add here Content .."
        aria-describedby ="sizing-addon2">
        </textarea>
      </div>

      @foreach($sectionTypes as $sectionType)
        <div class="form-group">
          <label for="section_name">Choose {{ $sectionType->section_type_name }}</label> <br>
          Hold down the Ctrl (windows) / Command (Mac) button to select multiple sections.
          <select multiple name="section_id[]" class="form-control">
            @foreach($sectionType->sections as $section)
              <option value="{{ $section->id }}">{{ $section->section_name }}</option>
            @endforeach
          </select>  
        </div>
      @endforeach

      <div class="form-group">
        <label for="tag_name">Tag Name:</label> 
      </div>
      <select id="tokenize" multiple="multiple" name="tag_name[]" class="tokenize-sample">
        @foreach($tags as $tag)
          <option value="{{ $tag->tag_name }}">{{ $tag->tag_name }}</option>
        @endforeach
      </select>

      <button type="submit" class="btn btn-primary form-control">Add</button>
    </form>
  </div>  
  
  <div class="col-sm-2">
    <div class="form-group">
      <label for="album_name">Choos Galleries</label>
      {!! $mediaLibrary !!}
    </div>
  </div>
</div>


<link rel="stylesheet" type="text/css" href="{{ url('cms/app/Modules/Content/Resources/Views/contentitems/assets/jquery.tokenize.css') }}">
<script src="{{ url('cms/app/Modules/Content/Resources/Views/contentitems/assets/jquery.tokenize.js') }}"></script>
<script>$('#tokenize').tokenize();</script>
@include('content::contentitems.assets.addcontentgalleries')
@include('content::contentitems.assets.tinymce')
@stop