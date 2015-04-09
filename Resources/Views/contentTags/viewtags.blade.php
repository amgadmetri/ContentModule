@extends('app')
@section('content')
<div class="container">
	<div class="col-sm-9">

		<table class="table table-striped">
			<tr>
				<th>Tag id</th>
				<th>Tag title</th>
				<th>Options</th>
			</tr>
			@foreach($tags as $tag)
			<tr>
				<th>{{ $tag->id }}</th>
				<th>{{ $tag->tag_content }}</th>
				<th>
					<a class="btn btn-default" href='{{ url("/content/tags/update/$tag->id") }}' role="button">Edit</a> 
					<a class="btn btn-default" href='{{ url("/content/tags/delete/$tag->id") }}' role="button">Delete</a> 
				</th>
			</tr>
			@endforeach
		</table>
	</div>
</div>
@stop