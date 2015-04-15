@extends('app')
@section('content')
<div class="container">
	<div class="col-sm-9">

		<table class="table table-striped">
			<tr>
				<th>Section Type id</th>
				<th>Section Type Name</th>
				<th>Options</th>
			</tr>
			@foreach($sectionTypes as $sectionType)
			<tr>
				<th>{{ $sectionType->id }}</th>
				<th>{{ $sectionType->section_type_name }}</th>
				<th>
					<a class="btn btn-default" href='{{ url("/content/sectiontypes/update/$sectionType->id") }}' role="button">Edit</a> 
					<a class="btn btn-default" href='{{ url("/content/sectiontypes/delete/$sectionType->id") }}' role="button">Delete</a> 
				</th>
			</tr>
			@endforeach
		</table>
	</div>
</div>
@stop