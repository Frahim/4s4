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


    

});