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
                if ( response.data.errors ) {
                    $('#plugin-name').html(response.data.errors.plugin_name);
                    $('#plugin-slug').html(response.data.errors.plugin_slug);
                    $('#plugin-version').html(response.data.errors.plugin_version);
                    $('#php-version').html(response.data.errors.php_version);
                    $('#wp-version').html(response.data.errors.wordpress_version);
                    $('#tested-version').html(response.data.errors.tested_version);
                    $('#wpte-add-plugin-loader').removeClass('wpte-add-plugin-loader');
                    return false;
                }

                if ( response.data.added ) {
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

    $('.wpte-popup-save-button').on('click', function(e){
        e.preventDefault();
        var data={
            plugin_name: $('#wpte_pm_plugin_name').val(),
            plugin_slug: $('#wpte_pm_plugin_slug').val(),
            plugin_version: $('#wpte_pm_plugin_version').val(),
            php_version: $('#wpte_pm_plugin_php_version').val(),
            wordpress_version: $('#wpte_pm_plugin_wordpress_version').val(),
            tested_version: $('#wpte_pm_plugin_wordpress_tested_version').val(),
            demo_url: $('#wpte_pm_plugin_demo_url').val(),
            description: $('#wpte_pm_plugin_description').val(),
            logo_id: $('.wpte-pm-logo-id').val(),
        }
        wpte_insert_data( data );
    });

    // Logo Upload
    var frame;

    $(document).on('click', '#wpte-pm-attachment', function(){

       if ( frame ) {
           frame.open();
           return;
       }

       frame = wp.media({
           title:'Select Image',
           button:{
               'text':'Insert Image'
           },
           multiple:false
       });

       var wpteVal = $(this),
           ImageId = ".wpte-pm-logo-id",
           ImageUrl = ".wpte-pm-logo-url";

       frame.on('select', function(e){
           var attachment = frame.state().get('selection').first().toJSON();
           console.log(attachment);
           wpteVal.find(ImageId).val(attachment.id);
           wpteVal.find(ImageUrl).val(attachment.url);
           wpteVal.find('img').remove();
           wpteVal.append(
               `<img src="${attachment.url}" alt="${attachment.id}">
               `
           )

       });

       frame.open();
   });


     // Tabs
     $(document).ready(function() {


        // Have the previously selected tab open
        if (sessionStorage.activeTab) {

            $('.wpte-pm-single-plugin-tab-content ' + sessionStorage.activeTab).show().siblings().hide();
            $(".wpte-pm-single-plugin-tab-button li a[href=" + "\"" + sessionStorage.activeTab + "\"" + "]").parent().addClass('active').siblings().removeClass('active');
        
        }
        
        // Enable, disable and switch tabs on click
        $('.wpte-pm-single-plugin-tab-button > .btn > a').on('click', function(e)  {

            e.preventDefault();

            var currentAttrValue = $(this).attr('href');
            var activeTab = $(this).attr('href');

            if(activeTab.length){
                 
                // Show/Hide Tabs
                $('.wpte-pm-single-plugin-tab-content ' + currentAttrValue).fadeIn('fast').siblings().hide();
                sessionStorage.activeTab = currentAttrValue;

                $(this).parent('li').addClass('active').siblings().removeClass('active');
               
              }

        }); 

    });


})(jQuery);