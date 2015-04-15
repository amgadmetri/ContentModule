@extends('app')

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

    <form method="post">
      <input name="_token" type="hidden" value="{{ csrf_token() }}">

      <div class="form-group">
        <label for="alias">Content Alias</label>
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
        <label for="status">Content Status</label>
        <select name="status" class="form-control">
          <option @if(old('status') === "published") selected @endif value="published">Published</option>
          <option @if(old('status') === "draft") selected @endif value="draft">Draft</option>
          <option @if(old('status') === "suspend") selected @endif value="suspend">Suspend</option>
          <option @if(old('status') === "delete") selected @endif value="delete">Delete</option>
        </select>  
      </div>

      <div class="form-group">
        <label for="title">Content Title</label>
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
        <label for="description">Content Description</label>
        <input 
        type             ="text" 
        class            ="form-control" 
        name             ="description" 
        value            ="{{ old('description') }}" 
        placeholder      ="Content Description .." 
        aria-describedby ="sizing-addon2"
        >
      </div>

      <div class="form-group">
        <label for="content">Content</label>
        <textarea 
        class            ="form-control" 
        rows             ="3" name="content" 
        value            ="{{ old('content') }}" 
        placeholder      ="Add content here .."
        aria-describedby ="sizing-addon2">
        </textarea>
      </div>
      
      @foreach($sectionTypes as $sectionType)
        <div class="form-group">
          <label for="section_name">Choose {{ $sectionType->section_type_name }}</label> <br>
          Hold down the Ctrl (windows) / Command (Mac) button to select multiple sections.
          <select multiple name="section_id[]" class="form-control">
            @foreach($sectionType->contentSections as $section)
              <option value="{{ $section->id }}">{{ $section->section_name }}</option>
            @endforeach
          </select>  
        </div>
      @endforeach

      <div class="form-group">
        <label for="tag_content">Tag Name:</label> 
      </div>
      <select id="tokenize" multiple="multiple" name="tag_content[]" class="tokenize-sample">
        @foreach($tags as $tag)
        <option value="{{ $tag->tag_content }}">{{ $tag->tag_content }}</option>
        @endforeach
      </select>

      <button type="submit" class="btn btn-primary form-control">Add Content</button>
    </form>
  </div>  

  <div class="col-sm-2">
    <label for="album_name">Choos Galleries</label>
    {!! $mediaLibrary !!}
  </div>
</div>


<link rel="stylesheet" type="text/css" href="{{ str_replace('public', 'app', url('Modules/Content/Resources/Views/contentItems/assets/jquery.tokenize.css')) }}">
<script src="{{ str_replace('public', 'app', url('Modules/Content/Resources/Views/contentItems/assets/jquery.tokenize.js')) }}"></script>
<script>$('#tokenize').tokenize();</script>
@include('content::contentItems.assets.addcontentgalleries')
@include('content::contentItems.assets.tinymce')
@stop