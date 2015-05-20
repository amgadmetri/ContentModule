@extends('app')
@section('content')

<div class="container">
	<div class="col-sm-9">

		<h3>{{ $sectionType->section_type_name }}'s Sections</h3>
		@if(\CMS::permissions()->can('add', 'Sections'))
			<a 
			class ="btn btn-default" href='{{ url("admin/content/sections/create", $sectionType->id) }}' 
			role  ="button">
			Add Sections
			</a>
		@endif

		<table class="table table-striped">
			<thead>
				<tr>
					<th>Section id</th>
					<th>Section title</th>
					<th>Section is active</th>
					<th>Options</th>
				</tr>
			</thead>
			<tbody>
				@foreach($sections as $section)
					<tr>
						<th>{{ $section->id }}</th>
						<th>{{ $section->section_name }}</th>
						<th>{{ $section->is_active }}</th>
						<th>
							@if(\CMS::permissions()->can('edit', 'Sections'))
								<a 
								class ="btn btn-default" 
								href  ='{{ url("admin/content/sections/edit/$section->id") }}' 
								role  ="button">
								Edit
								</a> 
							@endif
							@if(\CMS::permissions()->can('delete', 'Sections'))
								<a 
								class ="btn btn-default" 
								href  ='{{ url("admin/content/sections/delete/$section->id") }}' 
								role  ="button">
								Delete
								</a> 
							@endif
						</th>
					</tr>
				@endforeach
			</tbody>
		</table>

	</div>
</div>
@stop