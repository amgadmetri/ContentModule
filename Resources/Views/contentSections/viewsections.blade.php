@extends('app')
@section('content')
<div class="container">
	<div class="col-sm-9">

		<table class="table table-striped">
			<tr>
				<th>Section id</th>
				<th>Section Type</th>
				<th>Section title</th>
				<th>Section is active</th>
				<th>Options</th>
			</tr>
			@foreach($sections as $section)
			<tr>
				<th>{{ $section->id }}</th>
				<th>{{ $section->contentSectionType->section_type_name }}</th>
				<th>{{ $section->section_name }}</th>
				<th>{{ $section->is_active }}</th>
				<th>
					@if(\AclRepository::can('edit', 'Sections'))
						<a 
						class ="btn btn-default" 
						href  ='{{ url("/content/sections/update/$section->id") }}' 
						role  ="button">
						Edit
						</a> 
					@endif
					@if(\AclRepository::can('delete', 'Sections'))
						<a 
						class ="btn btn-default" 
						href  ='{{ url("/content/sections/delete/$section->id") }}' 
						role  ="button">
						Delete
						</a> 
					@endif
				</th>
			</tr>
			@endforeach
		</table>
	</div>
</div>
@stop