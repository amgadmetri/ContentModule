@extends('content::master')
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
        <label for="parent_id">Parent Section:</label>
        <select name="parent_id" class="form-control">
          <option value="0">New Section</option>
          @foreach($sections as $section)
          <option value="{{ $section->id }}">{{ $section->section_name }}</option>
          @endforeach
        </select>  
      </div>


      <div class="form-group">
        <label for="section_name">Section Name:</label>
        <input type="text" class="form-control" name="section_name" value="{{ old('section_name') }}" placeholder="Add section here .." aria-describedby="sizing-addon2">
      </div>

      <div class="form-group">
        <label for="is_active">is active:</label>
        <select name="is_active" class="form-control">
          <option @if(old('is_active') === '1') selected @endif value="1">Active</option>
          <option @if(old('is_active') === '0') selected @endif value="0">Not active</option>
        </select>  
      </div>

      <button type="submit" class="btn btn-primary form-control">Add Section</button>
    </form>

  </div>
</div>

@stop