@extends('content::master')
@section('content')
<div class="container">
	<div class="col-sm-9">
<h3>{{ $contentItems->contentLanguagesVars->first()->title }}</h3>
	
<br>
	{{ $contentItems->contentLanguagesVars->first()->content }}
	<br><br>
	<b>You are here:</b>
	{{$contentItems->contentSections->first()->section_name}}
	/
	{{$contentItems->alias}}
	<br>
	
	<b>Tags :</b>
	@foreach ($contentItems->contentTags as $contentTag)
		<br>{{ $contentTag->tag_content }} 
	@endforeach

	</div>
</div>
@stop