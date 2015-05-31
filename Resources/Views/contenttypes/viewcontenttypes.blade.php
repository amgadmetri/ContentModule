@extends('app')
@section('content')

<div class="container">
	<div class="col-sm-9">

		<table class="table table-striped">
			<thead>
				<tr>
					<th>Content Type id</th>
					<th>Content Type Name</th>
					<th>Options</th>
				</tr>
			</thead>
			<tbody>
				@foreach($contentTypes as $contentType)
				<tr>
					<th>{{ $contentType->id }}</th>
					<th>{{ $contentType->content_type_name }}</th>
					<th>
						@if(\CMS::permissions()->can('show', 'Contents'))
							<a 
							class ="btn btn-default" 
							href  ='{{ url("admin/content/show", $contentType->id) }}' 
							role  ="button">
							Contents
							</a> 
					@endif
					</th>
				</tr>
			</tbody>
			@endforeach
		</table>
	</div>
</div>
@stop