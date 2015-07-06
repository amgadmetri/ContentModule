<li>
	<a href='{{ url("category" ,[$section->id]) }}'>
		{{ $section->section_name }}
	</a>
	@if ($section->children->count() > 0)
		<ul class='nav nav-pills'>
			{!! \CMS::sections()->getSectionTree($sectionTypeName, $path, $language, $perPage, $section->id) !!}
		</ul>
	@endif
</li>