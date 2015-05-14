@extends('app')
@section('content')

<div class="container">
	<div class="col-sm-8">

		@if (count($errors) > 0)
		<div class="alert alert-danger">
			<strong>Whoops!</strong> There were some problems with your input.<br><br>
			<ul>
				@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
		@endif

		@if (Session::has('message'))
		<div class="alert alert-success">
			<ul>
				<li>{{ Session::get('message') }}</li>
			</ul>
		</div>
		@endif

		<h3>Albums for content : {{ $contentItem->data['title'] }}</h3>
		
		<div class="col-xs-12 col-md-12" id="albumGalleryContent">
		@foreach($contentAlbums as $contentAlbum)
			<div class="col-xs-6 col-md-4">
				<div class="thumbnail">
					<input name="gallery_ids[]" type="hidden" id="gallery_id" value="{{ $contentAlbum->id }}">
					@if ($contentAlbum->galleries[0]->type == 'photo')
					<img width="149" height="149" src='{{ $contentAlbum->galleries[0]->path }}' alt="{{ $contentAlbum->galleries[0]->caption }}"/>
					@else
					<img width="149" height="149" src='http://img.youtube.com/vi/{{$gallery->galleries[0]->video_path}}/0.jpg' alt="{{ $gallery->galleries[0]->caption }}" width="100" height="100">
					@endif
					<div class="caption" align="center">
						<p><h4>{{ $contentAlbum->album_name }}</h4>
							<a class="btn btn-default" href='{{ url("admin/gallery/album/preview/$contentAlbum->id") }}' target="_blank">Preview</a>
							<a class="btn btn-default" href='{{ url("admin/content/contentalbums/deletealbum", [$contentItem->id, $contentAlbum->id]) }}' role="button">Delete</a>
						</p>
					</div>
				</div>
			</div>
			@endforeach
		</div>

	</div>
	<div class="col-sm-2">
		<label for="album_name">Choos Albums</label>
		{!! $contentAlbumMediaLibrary !!}
	</div>
</div>
@include('content::contentItems.assets.addcontentalbums')
@stop