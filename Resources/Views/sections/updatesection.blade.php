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

    <form method="post">
      <input name="_token" type="hidden" value="{{ csrf_token() }}">
      
      <div class="form-group">
        <label for="parent_id">Parent:</label>
        <select name="parent_id" class="form-control">
          <option value="0">New</option>
          @foreach($parentSections as $parentSection)
            @if($section->id !== $parentSection->id)
              <option @if($parentSection->id === $section->parent_id) selected @endif value="{{ $parentSection->id }}">{{ $parentSection->section_name }}</option>
            @endif
          @endforeach
        </select>  
      </div>

      <div class="form-group">
        <label for="section_name">Name:</label>
        <input type="text" class="form-control" name="section_name" value="{{ $section->section_name }}" placeholder="Add name here .." aria-describedby="sizing-addon2">
      </div>

      <div class="form-group">
        <label for="is_active">is active:</label>
        <select name="is_active" class="form-control">
          <option @if($section->is_active === 'True') selected @endif value="1">Active</option>
          <option @if($section->is_active === 'False') selected @endif value="0">Not active</option>
        </select>  
      </div>

      <button type="submit" class="btn btn-primary form-control">Update</button>
    </form>
  </div>
</div>
@stop