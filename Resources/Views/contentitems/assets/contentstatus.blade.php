<script type="text/javascript">
	$(document).on('submit', '#content_status_form', function(e)
	{
		e.preventDefault();
		window.location = '{{ url("admin/content/show", $contentType->id) }}' + '/' + $(this).serializeArray()[0].value;
	});
</script>