@extends('content::master')
@section('content')
<div class="container">
	<div class="col-sm-9">

		<table class="table table-striped">
		   <tr class="info">
		    <th>Content ID</th>
		    <th>Content alias</th>
		    <th>Content title</th>
		    <th>Content description</th>
		    <th>Update Content</th>
		    <th>Delete Content</th>
		    <th>View Content</th>
		  </tr>
			@foreach($contentItems as $contentItem)
		  <tr>
		  	<th>{{ $contentItem->id }}</th>
		    <th>{{ $contentItem->alias }}</th>
		    <th>{{ $contentItem->contentLanguagesVars->first()->title }}</th>
		    <th>{{ $contentItem->contentLanguagesVars->first()->description }}</th>
		    <th>
			    <a class="btn btn-primary" href='{{ url("/content/update/$contentItem->id") }}' data-toggle="tooltip" data-placement="left" title="Edit">
	      		<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
			    </a> 
		    </th>
		    <th>
		    	<a class="btn btn-danger" href='{{ url("/content/delete/$contentItem->id") }}' data-toggle="tooltip" data-placement="left" title="Delete">
	      		<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
			    </a> 
		    </th>
		    <th>
		    	<a class="btn btn-success" href='{{ url("/content/display/$contentItem->id") }}' data-toggle="tooltip" data-placement="left" title="View">
	      		<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
			    </a> 
		    </th>
		  </tr>
			@endforeach

		</table>





	</div>
</div>
@stop