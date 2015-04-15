@extends('app')

@section('content')

<div class="container">
	<div class="col-sm-9">
		<table class="table table-striped">
			<tr>
				<th>Content ID</th>
				<th>Content alias</th>
				<th>Options</th>
			</tr>
			@foreach($contentItems as $contentItem)
			<tr>
				<th>{{ $contentItem->id }}</th>
				<th>{{ $contentItem->alias }}</th>
				<th>
					<a class="btn btn-default" href='{{ url("/content/update/$contentItem->id") }}' role="button">Edit</a> 
					<a class="btn btn-default" href='{{ url("/content/delete/$contentItem->id") }}' role="button">Delete</a> 
					<a class="btn btn-default" href='{{ url("/language/languagecontents/show/content/$contentItem->id") }}'role="button">Translations</a> 
					<a class="btn btn-default" href='{{ url("/Acl/permissions/show/content/$contentItem->id") }}'role="button">Permissions</a> 
				</th>
			</tr>
			@endforeach
		</table>
	</div>
</div>
@stop