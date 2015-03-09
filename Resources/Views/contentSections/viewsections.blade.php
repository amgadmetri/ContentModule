@extends('content::master')
@section('content')
<div class="container">
	<div class="col-sm-9">

		<table class="table table-striped">
		   <tr class="info">
		    <th>Section id</th>
		    <th>Section title</th>
		    <th>Section is active</th>
		    <th>Update Section</th>
		    <th>Delete Section</th>
		  </tr>
			@foreach($sections as $section)
		  <tr>
		    <th>{{ $section->id }}</th>
		    <th>{{ $section->section_name }}</th>
		    <th>{{ $section->is_active }}</th>
		    <th>
		    <a class="btn btn-primary" href='{{ url("/content/sections/update/$section->id") }}' data-toggle="tooltip" data-placement="left" title="Edit">
	      	<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
			</a> 
			    
		    </th>
		    <th>
		    <a class="btn btn-danger" href='{{ url("/content/sections/delete/$section->id") }}' data-toggle="tooltip" data-placement="left" title="Delete">
	      	<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>	
			</a> 
			     
		    </th>
		  </tr>
			@endforeach

		</table>





	</div>
</div>
@stop