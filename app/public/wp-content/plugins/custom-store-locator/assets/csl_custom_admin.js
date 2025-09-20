jQuery(document).ready( function( $ ) {

    $('#upload_image_button').click(function(e) {
        e.preventDefault();

        var custom_uploader = wp.media({
            title: 'Custom Image',
            button: {
                text: 'Upload Image'
            },
            multiple: false  // Set this to true to allow multiple files to be selected
        })
        .on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#csl_custom_map_marker').attr('src', attachment.url);
            $('#csl_custom_map_marker').val(attachment.url);

        })
        .open();
    });

	const pickr_primary = Pickr.create({
	  el: '.csl_primary_color_picker',
	  theme: 'nano',
	  default: colors_object.primary,
	  components: {
		preview: true,
		opacity: true,
		hue: true,
		interaction: {
		  input: true,
		  clear: true,
		  save: true
		}
	  }
	});
	
	const input_primary = document.getElementById('csl_primary_color');
	
	pickr_primary.on('change', (color) => {
		if(color) {
			const hexColor = color.toHEXA().toString();
			input_primary.value = hexColor;
		}
	});

	pickr_primary.on('save', (color) => {
		if(color) {
			const hexColor = color.toHEXA().toString();
			input_primary.value = hexColor;
		}
	});
	
	pickr_primary.on('clear', () => {
		input_primary.value = colors_object.default_primary;
		pickr_primary.setColor(colors_object.default_primary);
	});

	const pickr_secondary = Pickr.create({
	  el: '.csl_secondary_color_picker',
	  theme: 'nano',
	  default: colors_object.secondary,
	  components: {
		preview: true,
		opacity: true,
		hue: true,
		interaction: {
		  input: true,
		  clear: true,
		  save: true
		}
	  }
	});
	
	const input_secondary = document.getElementById('csl_secondary_color');
	
	pickr_secondary.on('change', (color) => {
		if(color) {
			const hexColor = color.toHEXA().toString();
			input_secondary.value = hexColor;
		}
	});

	pickr_secondary.on('save', (color) => {
		if(color) {
			const hexColor = color.toHEXA().toString();
			input_secondary.value = hexColor;
		}
	});
    
	pickr_secondary.on('clear', () => {
	  input_secondary.value = colors_object.default_secondary;
	  pickr_secondary.setColor(colors_object.default_secondary);
	});

});