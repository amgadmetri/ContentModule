@extends('content::master')
@section('content')
<div class="container">
	<div class="col-sm-9">

		<table class="table table-striped">
		   <tr class="info">
		    <th>Tag id</th>
		    <th>Tag title</th>
		    <th>Update Tag</th>
		    <th>Delete Tag</th>
		  </tr>
			@foreach($tags as $tag)
		  <tr>
		    <th>{{ $tag->id }}</th>
		    <th>{{ $tag->tag_content }}</th>
		    <th>
		    <a class="btn btn-primary" href='{{ url("/content/tags/update/$tag->id") }}'>
	      		 <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
			    </a> 
			    
		    </th>
		    <th>
		    <a class="btn btn-danger" href='{{ url("/content/tags/delete/$tag->id") }}'>
	      		 <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>	
			    </a> 
			     
		    </th>
		  </tr>
			@endforeach

		</table>





	</div>
</div>
@stop