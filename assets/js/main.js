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

    // File Upload
    var imageframe;

    // Add Plugin
    $(document).on('click', '#wpte-pm-attachment', function(){

        if ( imageframe ) {
            imageframe.open();
            return;
        }

        imageframe = wp.media({
            title:'Select Image',
            button:{
                'text':'Insert Image'
            },
            multiple:false
        });

        // Add Plugin
        var wpteVal = $(this),
            ImageId = ".wpte-pm-logo-id",
            ImageUrl = ".wpte-pm-logo-url";

            imageframe.on('select', function(e){

            var attachment = imageframe.state().get('selection').first().toJSON();

            wpteVal.find(ImageId).val(attachment.id);
            wpteVal.find(ImageUrl).val(attachment.url);
            wpteVal.find('img').remove();
            wpteVal.append(
                `<img src="${attachment.url}" alt="${attachment.id}">
                `
            );

        });

        imageframe.open();
    });


    var frame = [];
    // Add Product
    $(document).on('click', '#wpte-pm-product-attachment', function(e){
           e.preventDefault();
           var id = $(this).data('id');
            
           if ( frame[id] ) {
               frame[id].open();
               return;
           }
   
           frame[id] = wp.media({
               title:'Select Image',
               button:{
                   'text':'Insert Image'
               },
               multiple:false
           });
   
           var wpteFileVal = $(this).parent(),
                fileId = ".wpte-pm-file-id",
                fileUrl = ".wpte-pm-file-url";
   
           frame[id].on('select', function(e){
               var attachment = frame[id].state().get('selection').first().toJSON();
               //console.log(attachment);
               wpteFileVal.find(fileId).val(attachment.id);
               wpteFileVal.find(fileUrl).val(attachment.url);
   
           });
   
           frame[id].open();

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

    // Variable Fields

    setTimeout(function(){  $(".wpte-pm-variable-product-data").show(); }, 3000);
     // Admin Accordion
     

     if( $('.wpte-pm-variable-product-header').hasClass('wpte-pm-active') ){
        $('.wpte-pm-active').next().show();
     };

     $(document).on("click",".wpte-pm-variable-product-header", function(){

        if( $(this).hasClass('wpte-pm-active') ){
             $(this).removeClass('wpte-pm-active');
             $(this).next().slideUp();
        }else{
             $(this).addClass('wpte-pm-active');
             $(this).next().slideDown(); 
        }
    });

    // Add Files
    var wrapper         = $(".wpte-pm-variable-product-options"); //Fields wrapper
    var add_field      = $("#wpte-pm-variable-add-field"); //Add button ID

    var i = $('#wpte_plugin_name_count').val();

    $(add_field).on('click', function(){
         $(wrapper).append(`<div class="wpte-pm-variable-product-area">
         <div class="wpte-pm-variable-product-header wpte-pm-active">
                <div class="wpte-pm-variable-product-name">
                    Product Layouts Pro
                </div>
                <div class="wpte-pm-variable-product-remove-button">
                ╳
                </div>
         </div>
         <div class="wpte-pm-variable-product-content">
            <div class="wpte-pm-variable-product-content-inner">
                <div class="wpte-pm-variable wpte-pm-varition-name">
                    <div>
                        <label for="wpte_pm_variation_name">Variation Name:</label>
                        <input type="text" id="wpte_pm_variation_name" name="wpte_pm_variation_name[]">
                    </div>
                    
                    <div>
                        <label for="wpte_pm_variation_activation_limit">Activation Limit:</label>
                        <input type="text" id="wpte_pm_variation_activation_limit" name="wpte_pm_variation_activation_limit[]">
                    </div>
                    
                    <div>
                        <label for="wpte_pm_variation_price">Price:</label>
                        <input type="text" id="wpte_pm_variation_price" name="wpte_pm_variation_price[]">
                    </div>

                    <div>
                        <label for="wpte_pm_variation_path">Product Path:</label>
                        <input type="text" id="wpte_pm_variation_path" name="wpte_pm_variation_path[]">
                    </div>
                    
                    <div>
                        <label for="wpte_pm_variation_recurring_payment">Recurring Payment:</label>
                        <input type="hidden" name="wpte_pm_variation_recurring_payment[]" value="0" />
                        <input type="checkbox" id="wpte_pm_variation_recurring_payment" name="wpte_pm_variation_recurring_payment[]" value="1">
                    </div>

                    <div>
                        <label for="wpte_pm_variation_recurring_period">Recurring Period:</label>
                        <select name="wpte_pm_variation_recurring_period[]" id="wpte_pm_variation_recurring_period">
                            <option value="days">Days</option>
                            <option value="months">Months</option>
                            <option value="years">Years</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="wpte_pm_variation_recurring_times">Times:</label>
                        <input type="number" id="wpte_pm_variation_recurring_times" name="wpte_pm_variation_recurring_times[]">
                    </div>
                    <div>
                        <div id="wpte-pm-product-attachment-area">
                                <input type="hidden" class="wpte-pm-file-id" name="wpte_pm_file_id[]" value="">
                                <input type="text" class="wpte-pm-file-url" name="wpte_pm_file_url[]" value="">
                                <button id="wpte-pm-product-attachment" data-id="${i}">Choose File</button>
                        </div>
                    </div>
                </div>
            </div>
         </div>
    </div>`); //add input box
    i++;
    });

    $(wrapper).on("click",".wpte-pm-variable-product-remove-button", function(e){ //user click on remove text
         e.preventDefault(); 
         var product_variation_id = $(this).parent().parent('div').find('.product_variation_id').val();
         $(this).parent().parent('div').find('.product_variation_id_remove').val(product_variation_id);
         $(this).parent().parent('div').hide();
     });

    //  Insert Product Data
    function wpte_insert_product_data( data ) {

        $.ajax({
            type: 'POST',
            url: wptePlugin.ajaxUrl,
            data: {
                action: "wpte_add_product",
                _nonce: wptePlugin.wpte_nonce,
                data: data
            },
            beforeSend: function () {
               $('#wpte-add-plugin-loader').addClass('wpte-add-plugin-loader');
            },
            success: function (response) {
                $('#wpte-add-plugin-loader').removeClass('wpte-add-plugin-loader');
                console.log(response);
                // if ( response.data.errors ) {
                //     $('#plugin-name').html(response.data.errors.plugin_name);
                //     $('#plugin-slug').html(response.data.errors.plugin_slug);
                //     $('#plugin-version').html(response.data.errors.plugin_version);
                //     $('#php-version').html(response.data.errors.php_version);
                //     $('#wp-version').html(response.data.errors.wordpress_version);
                //     $('#tested-version').html(response.data.errors.tested_version);
                //     $('#wpte-add-plugin-loader').removeClass('wpte-add-plugin-loader');
                //     return false;
                // }

                // if ( response.data.added ) {
                //     setTimeout(function(){ 
                //         location.reload()
                //     }, 2000);
                // }

            },
            error: function (data) {
                console.log('error')
            }
        });
    }

    $('.wpte-product-save-button').on('click', function(e){
        e.preventDefault();

        var data = $('#wpte-pm-product-form').serializeJSON();

        wpte_insert_product_data( data );
    });


})(jQuery);