<li>
	<a href='{{ url($link . '/' . $section->id) }}'>
		{{ $section->section_name }}
	</a>
	@if ($section->children->count() > 0)
		<ul class='nav nav-pills'>
			{!! \CMS::sections()->getSectionTree($link, $section->id) !!}
		</ul>
	@endif
</li>