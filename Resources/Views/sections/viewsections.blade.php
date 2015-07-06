@extends('core::app')
@section('content')

<div class="container">
	<div class="col-sm-9">

		<h3>All {{ $sectionType->section_type_name }}</h3>
		@if(\CMS::permissions()->can('add', 'Sections'))
			<a 
			class ="btn btn-default" href='{{ url("admin/content/sections/create", $sectionType->id) }}' 
			role  ="button">
			Add {{ $sectionType->section_type_name }}
			</a>
		@endif

		<table class="table table-striped">
			<thead>
				<tr>
					<th>id</th>
					<th>title</th>
					<th>description</th>
					<th>is active</th>
					<th>Options</th>
				</tr>
			</thead>
			<tbody>
				@foreach($sections as $section)
					<tr>
						<th>{{ $section->id }}</th>
						<th>{{ $section->data['title'] }}</th>
						<th>{{ $section->data['description'] }}</th>
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
							@if(\CMS::permissions()->can('show', 'LanguageContents'))
								<a 
								class ="btn btn-default" 
								href  ='{{ url("admin/language/languagecontents/show/section/$section->id") }}'
								role  ="button">
								Translations
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