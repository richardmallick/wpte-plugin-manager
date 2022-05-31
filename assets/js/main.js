;(function($){
    $(document).ready(function(){
        $('.wpte-pm-add-new-button button').on('click', function(){
            $('.wpte-pm-popup-wrapper').addClass('wpte-pm-popup-block');
            $('.wpte-pm-popup-box').slideDown() ;
        });

        $(document).on('click', 'body', function(e){
            if ( $(e.target).hasClass("wpte-pm-popup-wrapper") ){
                $('.wpte-pm-popup-box').slideUp() ;
                setTimeout(function(){
                    $('.wpte-pm-popup-wrapper').removeClass('wpte-pm-popup-block');
                }, 300);
            }
            
        });
  
        $(document).on('click', '.wpte-pm-popup-close, .wpte-popup-close-button', function(e){
            $('.wpte-pm-popup-box').slideUp() ;
            setTimeout(function(){
                $('.wpte-pm-popup-wrapper').removeClass('wpte-pm-popup-block');
            }, 300);
        });
    });

    function wpte_insert_data( data ) {

        $.ajax({
            type: 'POST',
            url: wptePlugin.ajaxUrl,
            data: {
                action: "wpte_add_new_plugin",
                _nonce: wptePlugin.wpte_nonce,
                data: data
            },
            beforeSend: function () {
               $('#wpte-add-plugin-loader').addClass('wpte-add-plugin-loader');
            },
            success: function (response) {

                if ( response.success ) {
                    setTimeout(function(){ 
                        location.reload()
                    }, 2000);
                }

            },
            error: function (data) {
                console.log('error')
            }
        });
    }

    $('.wpte-popup-save-button').on('click', function(){

        var data={
            plugin_name: $('#wpte_pm_plugin_name').val(),
            plugin_slug: $('#wpte_pm_plugin_slug').val(),
            plugin_version: $('#wpte_pm_plugin_version').val(),
            php_version: $('#wpte_pm_plugin_php_version').val(),
            wordpress_version: $('#wpte_pm_plugin_wordpress_version').val(),
            tested_version: $('#wpte_pm_plugin_wordpress_tested_version').val(),
            demo_url: $('#wpte_pm_plugin_demo_url').val(),
            description: $('#wpte_pm_plugin_description').val(),
        }
        wpte_insert_data( data );
    });

})(jQuery);