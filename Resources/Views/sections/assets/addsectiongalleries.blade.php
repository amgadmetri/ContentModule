<script type="text/javascript">
	$(document).ready(function () {

		url = '{{ url("admin/content/sections/sectiongalleries") }}';
		
		mediaLibrary.init(function(checkedValues)
		{
			console.log(url);
			$.ajax({
				url         : url,
				type        : 'GET',
				data        : {'ids': checkedValues},
				success     : function(data)
				{
					if(data[0].type === 'photo')
						img = '<img alt="' + data[0].caption + '" src="' + data[0].path + '"/>';

					$('#section_image').attr('src', data[0].path);
					$('input[name=section_image]').attr('value', data[0].id);
				}
			});
		});
	});
</script>
