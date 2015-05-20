<script type="text/javascript">
	$(document).ready(function () {
		contentAlbumMediaLibrary.init(function(checkedValues)
		{
			url = '{{ url("admin/content/contentalbums/create", $contentItem->id) }}';
			$.ajax({
				url         : url,
				type        : 'GET',
				data        : {'ids': checkedValues},
				success     : function(data)
				{
					location.reload();
				}
			});
		});
	});
</script>
