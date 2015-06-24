jQuery(document).ready(function($){
	$('body').on('click','.upload_ad_image', function(e) {
        var container = $(this).closest('.widget').attr('id');
		e.preventDefault();
		var image = wp.media({ 
			title: 'Upload Ad Image',
			multiple: false
            // mutiple: false restricts you from uploading multiple images at once
		}).open()
		.on('select', function(e){
			// This will return the selected image from the Media Uploader, the result is an object
			var uploaded_image = image.state().get('selection').first();
			// We convert uploaded_image to a JSON object to make accessing it easier
			// Output to the console uploaded_image
			console.log(uploaded_image);
			var image_url = uploaded_image.toJSON().url;
			// Let's assign the url value to the input field
			$('#'+container).find('.custom_media_url').val(image_url);
			$('#'+container).find('.custom_media_image').attr('src',image_url);
		});
	});
});