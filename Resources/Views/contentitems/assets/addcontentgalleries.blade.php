<script type="text/javascript">
	$(document).ready(function () {

		url = '{{ url("admin/content/contentgalleries") }}';
		
		contentImageMediaLibrary.init(function(checkedValues)
		{
			$.ajax({
				url         : url,
				type        : 'GET',
				data        : {'ids': checkedValues},
				success     : function(data)
				{
					if(data[0].type === 'photo')
						img = '<img alt="' + data[0].caption + '" src="' + data[0].path + '"/>';

					$('#content_image').attr('src', data[0].path);
					$('input[name=content_image]').attr('value', data[0].id);
				}
			});
		});

		mediaLibrary.init(function(checkedValues)
		{
			$.ajax({
				url         : url,
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
