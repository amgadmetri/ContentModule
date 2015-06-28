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
				<label for="tag_name">Tag Name:</label>
				<input type="text" class="form-control" name="tag_name" value="{{$tag->tag_name}}" placeholder="Add tag here .." aria-describedby="sizing-addon2">
			</div>
			
			<button type="submit" class="btn btn-primary form-control">Add Tag</button>
		</form>
		
	</div>
</div>
@stop