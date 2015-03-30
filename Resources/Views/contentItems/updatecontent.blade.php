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

  <div class="col-sm-2">
    <label for="album_name">Choos Galleries</label>
    @include('gallery::parts.modals.mediamodal')
  </div>
</div>


<link href="{{ asset('assets/css/jquery.tokenize.css') }}" rel="stylesheet">

<script src="{{ asset('assets/js/content/jquery.tokenize.js') }}"></script>
<script src="{{ asset('assets/js/content/addcontentgalleries.js') }}"></script>
<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>

<script>$('#tokenize').tokenize();</script>
<script>
tinymce.init({
    selector: "textarea",
    height: 300,
    theme: "modern",
    plugins: [
         "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
         "save table contextmenu directionality emoticons template paste textcolor"
   ],
   toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons", 
   style_formats: [
        {title: 'Bold text', inline: 'b'},
        {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
        {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
        {title: 'Example 1', inline: 'span', classes: 'example1'},
        {title: 'Example 2', inline: 'span', classes: 'example2'},
        {title: 'Table styles'},
        {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
    ]
 }); 
</script>
@stop