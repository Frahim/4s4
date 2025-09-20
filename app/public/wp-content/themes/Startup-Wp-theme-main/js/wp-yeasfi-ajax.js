jQuery(function ($) {
    $('.js-filter select, .js-filter input[type="date"]').on('change', function () {
        var cat = $('#cat').val();
       var date = $ ('#selected-date').val();  
        console.log(date);   
        var data = {
            action: 'filter_posts',
            cat: cat,
            date: date          
        };

        $.ajax({
            url: ajaxfilter.ajaxurl, // Changed from 'variables.ajax_url' to 'ajaxfilter.ajaxurl'
            type: 'POST',
            data: data,
            success: function (response) {
                $('.js-movies').html(response);
            }
        });
    });
});
