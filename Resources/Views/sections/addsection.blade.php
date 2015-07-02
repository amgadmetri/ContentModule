@extends('core::app')
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
    
    <div class="col-sm-12">
      <div class="col-sm-6">
       <div class="form-group">
        <label for="section_image">Image</label>
        <img class="img-responsive" src="http://placehold.it/200x200" width="200" height="200" id="section_image">
        <br>
        {!! $mediaLibrary !!}
       </div>
      </div>
    </div>

    <form method="post">
      <input name="_token" type="hidden" value="{{ csrf_token() }}">
      <input name="section_type_id" type="hidden" value="{{ csrf_token() }}">
      <input type="hidden" name="section_image">

      <div class="form-group">
        <label for="parent_id">Parent:</label>
        <select name="parent_id" class="form-control">
          <option value="0">New</option>
            @foreach($parentSections as $parentSection)
                <option value="{{ $parentSection->id }}">{{ $parentSection->section_name }}</option>
            @endforeach
        </select>  
      </div>


      <div class="form-group">
        <label for="section_name">Name:</label>
        <input type="text" class="form-control" name="section_name" value="{{ old('section_name') }}" placeholder="Add name here .." aria-describedby="sizing-addon2">
      </div>

      <div class="form-group">
        <label for="is_active">is active:</label>
        <select name="is_active" class="form-control">
          <option @if(old('is_active') === '1') selected @endif value="1">Active</option>
          <option @if(old('is_active') === '0') selected @endif value="0">Not active</option>
        </select>  
      </div>
      <button type="submit" class="btn btn-primary form-control">Add</button>
    </form>

  </div>
</div>

@include('content::sections.assets.addsectiongalleries')
@stop