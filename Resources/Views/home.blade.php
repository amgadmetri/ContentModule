@extends('content::master')
@section('content')
<div class="container">
	<div class="col-sm-9">


				<form method="post"  >
				<input name="_token" type="hidden" value="{{ csrf_token() }}">
				<div class="form-group">
  				<label for="title">Content Title</label>
  				<input type="text" class="form-control" placeholder="Add title here .." aria-describedby="sizing-addon2">
  				</div>
  				
  				<div class="form-group">
				<label for="description">Content Description</label>
				<input type="text" class="form-control" placeholder="Content Description .." aria-describedby="sizing-addon2">
				</div>

  				<div class="form-group">
  				<label for="content">Content</label>
  				<textarea class="form-control" rows="3" placeholder="Add content here .." aria-describedby="sizing-addon2"></textarea>
  				</div>

				<div class="form-group">
				        <label for="tag_content">Content Section</label>
				        <select multiple name="section_id" class="form-control" >
				         @foreach($tags as $tag)
				            <option value="{{ $tag->id }}">{{ $tag->tag_content }}</option>
				         @endforeach
				        </select>  
				</div>

  				<button type="submit" class="btn btn-primary form-control">Add Content</button>
  				</form>
				
				<!-- <div class="form-group">
			    <label for="exampleInputFile">File input</label>
			    <input type="file" id="exampleInputFile">
			    <p class="help-block">Example block-level help text here.</p>
			  </div> -->

</div>
</div>
<!-- <div class="input-group">
  <span class="input-group-addon" id="sizing-addon2">Add Content</span>
  <input type="text" class="form-control" placeholder="Username" aria-describedby="sizing-addon2">
</div> -->
@stop