<script type="text/javascript">
	$(document).ready(function () {
		mediaSelectedIds.init(function(checkedValues)
		{
			$.ajax({
				url         : window.location,
				type        : 'GET',
				data        : {'ids': checkedValues},
				success     : function(data)
				{
					if(data[0].type === 'photo')
						img = '<img alt="' + data[0].caption + '" src="' + data[0].path + '"/>';
					else
						img = '<iframe src="' + data[0].path + '" frameborder="0" allowfullscreen></iframe>';

					tinyMCE.execCommand('mceInsertContent', false, img);
				}
			});
		});
	});
</script>
