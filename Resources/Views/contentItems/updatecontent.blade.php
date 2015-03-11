@extends('app')

@section('content')
<div class="container">
  <div class="col-sm-9">
  
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
        type="text" 
        class="form-control" 
        name="alias" 
        value="{{ $contentItem->alias }}" 
        placeholder="Add alias here .." 
        aria-describedby="sizing-addon2"
        >
      </div>
      
      <div class="form-group">
        <label for="status">Content Status</label>
        <select name="status" class="form-control">
          <option @if($contentItem->status === 'published') selected @endif value="published">Published</option>
          <option @if($contentItem->status === 'draft') selected @endif value="draft">Draft</option>
          <option @if($contentItem->status === 'suspend') selected @endif value="suspend">Suspend</option>
          <option @if($contentItem->status === 'delete') selected @endif value="delete">Delete</option>
        </select>  
      </div>
      
      <div class="form-group">
        <label for="title">Content Title</label>
        <input 
        type="text" 
        class="form-control" 
        name="title" 
        value="{{ $contentData['title'] }}" 
        placeholder="Add title here .." 
        aria-describedby="sizing-addon2"
        >
      </div>
      
      <div class="form-group">
        <label for="description">Content Description</label>
        <input 
        type="text" 
        class="form-control" 
        name="description" 
        value="{{ $contentData['description'] }}" 
        placeholder="Content Description .." 
        aria-describedby="sizing-addon2"
        >
      </div>
      
      <div class="form-group">
        <label for="content">Content</label>
        <textarea 
        class="form-control" 
        rows="3" name="content" 
        value="" 
        placeholder="Content Description .." 
        aria-describedby="sizing-addon2">{{ $contentData['content'] }}</textarea>
      </div>
      
      <div class="form-group">
        <label for="section_name">Content Section</label>
        <select multiple name="section_id[]" class="form-control">
          
          @foreach($sections as $section)
          <option value="{{ $section->id }}" >{{ $section->section_name }}</option>
          @endforeach
          
          @foreach($contentItem->contentSections as $contentSection)
          <option value="{{ $contentSection->id }}" selected>{{ $contentSection->section_name }}</option>
          @endforeach
        </select>  
      </div>
      
      Add new tags..
      <div class="form-group">
        <select id="tokenize" multiple="multiple" name="tag_content[]" class="tokenize-sample">
          @foreach($tags as $tag)
          <option value="{{ $tag->tag_content }}">{{ $tag->tag_content }}</option>
          @endforeach
          
          @foreach ($contentItem->contentTags as $contentTag)
          <option value="{{ $contentTag->tag_content }}" selected>{{ $contentTag->tag_content }}</option>
          @endforeach
        </select>
      </div>
      
      <button type="submit" class="btn btn-primary form-control">Update Content</button>
    </form>
    
  </div>
</div>
@stop