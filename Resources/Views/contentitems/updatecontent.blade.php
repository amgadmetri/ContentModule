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

    <div class="form-group">
      <label for="content_image">Content Image</label>
      @if($contentItem->contentImage)
        <a href="{{ url('admin/gallery/show', $contentItem->contentImage->id) }}" target="_blank">
          <img class="img-responsive" src="{{ $contentItem->contentImage->path }}" width="200" height="200" id="content_image">
        </a>
      @else
        <img class="img-responsive" src="http://placehold.it/900x300" width="200" height="200" id="content_image">
      @endif
      <br>
      {!! $contentImageMediaLibrary !!}
    </div>

    <form method="post">
      <input name="_token" type="hidden" value="{{ csrf_token() }}">
      <input type="hidden" name="content_image" @if($contentItem->contentImage) value="{{ $contentItem->contentImage->id }}" @endif>
      
      <div class="form-group">
        <label for="alias">Alias</label>
        <input 
        type="text" 
        class="form-control" 
        name="alias" 
        value="{{ $contentItem->alias }}" 
        placeholder="Add alias here .." 
        aria-describedby="sizing-addon2"
        >
      </div>
      
      <div class="form-group">
        <label for="status">Status</label>
        <select name="status" class="form-control">
          <option @if($contentItem->status === 'published') selected @endif value="published">Published</option>
          <option @if($contentItem->status === 'draft') selected @endif value="draft">Draft</option>
          <option @if($contentItem->status === 'suspend') selected @endif value="suspend">Suspend</option>
        </select>  
      </div>
      
      <div class="form-group">
        <label for="title">Title</label>
        <input 
        type="text" 
        class="form-control" 
        name="title" 
        value="{{ $contentItem->data['title'] }}" 
        placeholder="Add title here .." 
        aria-describedby="sizing-addon2"
        >
      </div>
      
      <div class="form-group">
        <label for="description">Description</label>
        <input 
        type="text" 
        class="form-control" 
        name="description" 
        value="{{ $contentItem->data['description'] }}" 
        placeholder="Add here Description .." 
        aria-describedby="sizing-addon2"
        >
      </div>
      
      <div class="form-group">
        <label for="content">Content</label>
        <textarea 
        class="form-control" 
        rows="3" name="content" 
        value="" 
        placeholder="Add here Content .." 
        aria-describedby="sizing-addon2">{{ $contentItem->data['content'] }}</textarea>
      </div>

      @foreach($sectionTypes as $sectionType)
      <div class="form-group">
        <label for="section_name">Choose {{ $sectionType->section_type_name }}</label> <br>
        Hold down the Ctrl (windows) / Command (Mac) button to select multiple sections.
        <select multiple name="section_id[]" class="form-control">
          @foreach($sectionType->sections as $section)
            @if(in_array($section->id, $contentItem->sections->lists('id')))
             <option value="{{ $section->id }}" selected>{{ $section->section_name }}</option>
            @else
              <option value="{{ $section->id }}">{{ $section->section_name }}</option>
            @endif
          @endforeach
        </select>  
      </div>
      @endforeach
      
      Add new tags..
      <div class="form-group">
        <select id="tokenize" multiple="multiple" name="tag_name[]" class="tokenize-sample">
          @foreach($tags as $tag)
            @if(in_array($tag->id, $contentItem->tags->lists('id')))
              <option value="{{ $tag->tag_name }}" selected>{{ $tag->tag_name }}</option>
            @else
              <option value="{{ $tag->tag_name }}">{{ $tag->tag_name }}</option>
            @endif
          @endforeach
        </select>
      </div>
      
      <button type="submit" class="btn btn-primary form-control">Update</button>
    </form>
  </div>

  <div class="col-sm-2">
    <label for="album_name">Choos Galleries</label>
    {!! $mediaLibrary !!}
  </div>
</div>


<link rel="stylesheet" type="text/css" href="{{ url('cms/app/Modules/Content/Resources/Views/contentitems/assets/jquery.tokenize.css') }}">
<script src="{{ url('cms/app/Modules/Content/Resources/Views/contentitems/assets/jquery.tokenize.js') }}"></script>
<script>$('#tokenize').tokenize();</script>
@include('content::contentitems.assets.addcontentgalleries')
@include('content::contentitems.assets.tinymce')
@stop