<script type="text/javascript">
	$(document).ready(function () {
		contentAlbumMediaLibrary.init(function(checkedValues)
		{
			$.ajax({
				url         : window.location,
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
