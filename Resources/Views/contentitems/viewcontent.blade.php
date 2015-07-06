@extends('core::app')
@section('content')

<div class="container">
	<div class="col-sm-9">	
		
		<h3>All {{ $contentType->content_type_name }}</h3>
		<div class="col-sm-5">
			<form class="form-inline" method="get" id="content_status_form">  
				<div class="form-group">
					<label for="status">{{ $contentType->content_type_name }} Status</label>
					<select name="status" class="form-control">
						<option @if($status === "all") selected @endif value="all">All</option>
						<option @if($status === "published") selected @endif value="published">Published</option>
						<option @if($status === "draft") selected @endif value="draft">Draft</option>
						<option @if($status === "suspend") selected @endif value="suspend">Suspend</option>
					</select>  
				</div>
				<button type="submit" class="btn btn-primary form-control">submit</button>
			</form>
		</div>
		<div class="col-sm-4">
			@if(\CMS::permissions()->can('add', 'Contents'))
				<a 
				class ="btn btn-default" href='{{ url("admin/content/create", $contentType->id) }}' 
				role  ="button">
				Add {{ $contentType->content_type_name }}
				</a>
			@endif
		</div>
	</div>
	<div class="col-sm-9">

		<br>
		<table class="table table-striped">
			<tr>
				<th>ID</th>
				<th>alias</th>
				<th>Options</th>
			</tr>
			@foreach($contentItems as $contentItem)
				<tr>
					<th>{{ $contentItem->id }}</th>
					<th>{{ $contentItem->alias }}</th>
					<th>
						@if(\CMS::permissions()->can('edit', 'Contents'))
							<a 
							class ="btn btn-default" 
							href  ='{{ url("admin/content/edit/$contentItem->id") }}' 
							role  ="button">
							Edit
							</a> 
						@endif
						@if(\CMS::permissions()->can('delete', 'Contents'))
							<a 
							class ="btn btn-default" 
							href  ='{{ url("admin/content/delete/$contentItem->id") }}' 
							role  ="button">
							Delete
							</a> 
						@endif
						@if(\CMS::permissions()->can('show', 'LanguageContents'))
							<a 
							class ="btn btn-default" 
							href  ='{{ url("admin/language/languagecontents/show/content/$contentItem->id") }}'
							role  ="button">
							Translations
							</a> 
						@endif
						@if(\CMS::users()->userHasGroup(\Auth::user()->id, 'admin'))
							<a 
							class ="btn btn-default" 
							href  ='{{ url("admin/Acl/permissions/show/content/$contentItem->id") }}'
							role  ="button">
							Permissions
							</a>
						@endif
						@if(\CMS::permissions()->can('show', 'ContentAlbums'))
							<a 
							class ="btn btn-default" 
							href  ='{{ url("admin/content/contentalbums/show/$contentItem->id") }}'
							role  ="button">
							Albums
							</a>
						@endif
						@if(\CMS::permissions()->can('show', 'Seos'))
							<a class="btn btn-default" href='{{ url("admin/seo/show/contentItem/$contentItem->id") }}' role="button">SEO</a>
						@endif
					</th>
				</tr>
			@endforeach
		</table>
		{!! $contentItems->render() !!}
	</div>
</div>
@include('content::contentitems.assets.contentstatus')
@stop