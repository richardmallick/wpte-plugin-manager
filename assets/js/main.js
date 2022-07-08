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

    function wpte_insert_data( data, action ) {

        $.ajax({
            type: 'POST',
            url: wptePlugin.ajaxUrl,
            data: {
                action: action,
                _nonce: wptePlugin.wpte_nonce,
                data: data
            },
            beforeSend: function () {
               $('#wpte-add-plugin-loader').addClass('wpte-add-plugin-loader');
               $('#wpte-add-plugin-loaders').addClass('wpte-add-plugin-loader');
            },
            success: function (response) {

                if ( typeof(response.data.errors) != "undefined" && response.data.errors !== null ) {
                    $('#plugin-name').html(response.data.errors.plugin_name);
                    $('#plugin-slug').html(response.data.errors.plugin_slug);
                    $('#plugin-version').html(response.data.errors.plugin_version);
                    $('#php-version').html(response.data.errors.php_version);
                    $('#wp-version').html(response.data.errors.wordpress_version);
                    $('#tested-version').html(response.data.errors.tested_version);
                    $('#wpte-add-plugin-loader').removeClass('wpte-add-plugin-loader');
                    return false;
                }

                if ( typeof(response.data.update_errors) != "undefined" && response.data.update_errors !== null ) {
                    $('#plugins-name').html(response.data.update_errors.plugin_name);
                    $('#plugins-slug').html(response.data.update_errors.plugin_slug);
                    $('#plugins-version').html(response.data.update_errors.plugin_version);
                    $('#phps-version').html(response.data.update_errors.php_version);
                    $('#wps-version').html(response.data.update_errors.wordpress_version);
                    $('#testeds-version').html(response.data.update_errors.tested_version);
                    $('#wpte-add-plugin-loaders').removeClass('wpte-add-plugin-loader');
                    return false;
                }

                if ( typeof(response.data.added) != "undefined" && response.data.added !== null ) {
                    setTimeout(function(){ 
                        location.reload()
                    }, 2000);
                } else {
                    $('#wpte_plugin_update').val(response.data.updated);
                    $('#wpte-add-plugin-loaders').removeClass('wpte-add-plugin-loader');
                    setTimeout(function(){ 
                        $('#wpte_plugin_update').val(response.data.update);
                    }, 3000);
                }

            },
            error: function (data) {
                console.log('error')
            }
        });
    }

    $('.wpte-popup-save-button').on('click', function(e){
        e.preventDefault();
        var action = "wpte_add_new_plugin";
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
        wpte_insert_data( data, action );
    });

    $('#wpte_plugin_update').on('click', function(e){
        e.preventDefault();
        var action = "wpte_plugin_update";
        var data={
            plugin_id: $('#wpte_plugin_id').val(),
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
        wpte_insert_data( data, action );
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
                   
                </div>
                <div class="wpte-pm-variable-product-remove-button">
                ╳
                </div>
         </div>
         <div class="wpte-pm-variable-product-content">
            <div class="wpte-pm-variable-product-content-inner">
                <div class="wpte-pm-variable wpte-pm-varition-name">
                    <div class="wpte-pm-input-wrapper">
                        <div>
                            <label for="wpte_pm_variation_name">Variation Name:</label>
                            <input type="text" id="wpte_pm_variation_name" name="wpte_pm_variation_name[]" value="">
                        </div>
                        
                        <div>
                            <label for="wpte_pm_variation_path">Product Path:</label>
                            <input type="text" id="wpte_pm_variation_path" name="wpte_pm_variation_path[]" value="">
                        </div>
                        
                        <div>
                            <label for="wpte_pm_variation_price">Price:</label>
                            <input type="number" id="wpte_pm_variation_price" name="wpte_pm_variation_price[]" value="0">
                        </div>
                    </div>

                    <div class="wpte-pm-input-wrapper wpte-pm-input-wrapper-middle">
                        <div>
                            <label for="wpte_pm_variation_activation_limit">Activation Limit:</label>
                            <input type="number" id="wpte_pm_variation_activation_limit" name="wpte_pm_variation_activation_limit[]" value="0">
                        </div>

                        <div>
                            <label for="wpte_pm_files_name">File Name *</label>
                            <input type="text" id="wpte_pm_files_name" name="wpte_pm_files_name[]" value="">
                        </div>

                        <div>
                            <div id="wpte-pm-product-attachment-area">
                                <label for="wpte-pm-file-url">File:</label>
                                <input type="hidden" class="wpte-pm-file-id" name="wpte_pm_file_id[]" value="0">
                                <input type="text" class="wpte-pm-file-url" name="wpte_pm_file_url[]" value="">
                                <button id="wpte-pm-product-attachment" data-id="${i}"><span class="dashicons dashicons-media-document"></span></button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="wpte-pm-input-wrapper">
                        <div class="wpte-pm-input-checkbox">
                            <p>Recurring Payment:</p>
                            <input type="hidden" name="wpte_pm_variation_recurring_payment[]" value="0">
                            <input checked="" type="checkbox" id="wpte_pm_variation_recurring_payment-${i}" name="wpte_pm_variation_recurring_payment[]" value="1">
                            <label for="wpte_pm_variation_recurring_payment-${i}"></label>
                        </div>

                        <div>
                            <label for="wpte_pm_variation_recurring_period">Recurring Period:</label>
                            <select name="wpte_pm_variation_recurring_period[]" id="wpte_pm_variation_recurring_period" value="days">
                                
                                    <option selected="" value="Days">Days</option>
                                
                                    <option value="Months">Months</option>
                                
                                    <option value="Years">Years</option>
                                                                                            
                            </select>
                        </div>
                        
                        <div>
                            <label for="wpte_pm_variation_recurring_times">Times:</label>
                            <input type="number" id="wpte_pm_variation_recurring_times" name="wpte_pm_variation_recurring_times[]" value="0">
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
                $('#wpte_product_form_submit').val('Saved');
                setTimeout(() =>{
                    $('#wpte_product_form_submit').val('Save');
                }, 3000);

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

    $('.wpte-pm-add-new-linense').on('click', function(){
        $('.wpte-pm-popup-wrapper').addClass('wpte-pm-popup-block');
        $('.wpte-pm-popup-box').slideDown() ;
    });

    /**
     * License Add and Update
     * @param {*} data 
     * @param {*} action 
     * @param {*} This 
     */
    function wpte_product_license_add_update(data, action, This) {

        $.ajax({
            type: 'POST',
            url: wptePlugin.ajaxUrl,
            data: {
                action: action,
                _nonce: wptePlugin.wpte_nonce,
                data: data
            },
            beforeSend: function () {
                This.siblings('#wpte-add-plugin-loader').addClass('wpte-add-plugin-loader');
            },
            success: function (response) {

                console.log(response);
               
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
    /**
     * Add New License
     */
    $(document).on('click', '#wpte_popup_licnese_submit', function(e){
        e.preventDefault();
        var This = $(this)
            data = $('.wpte-pm-popup-box form').serializeJSON(),
            action = "wpte_add_license";

        wpte_product_license_add_update(data, action, This);

    });

    /**
     * Update License
     */
    $(document).on('click', '#wpte_popup_license_update', function(e){
        e.preventDefault();

        var This = $(this)
            data = $('.wpte-pm-popup-box form').serializeJSON(),
            action = "wpte_update_license";

        wpte_product_license_add_update(data, action, This);

    });

    /**
     * Delete License
     */
    function wpte_pm_delete( id, action, This ) {
        $.ajax({
            type: 'POST',
            url: wptePlugin.ajaxUrl,
            data: {
                action: action,
                _nonce: wptePlugin.wpte_nonce,
                id: id
            },
            beforeSend: function () {
                This.siblings('#wpte-add-plugin-loader').addClass('wpte-add-plugin-loader');
                This.siblings('#wpte-add-plugin-loaders').addClass('wpte-add-plugin-loader');
            },
            success: function (response) {

                if ( typeof(response.data.deleted) != "undefined" && response.data.deleted !== null ) {
                    setTimeout(function(){ 
                       location.reload();
                    }, 2000);
                } else {
                    setTimeout(function(){ 
                        $(location).attr('href', response.data.plugin_url);
                    }, 2000);
                }

            },
            error: function (data) {
                console.log('error')
            }
        });
    }

    $(document).on('click', '.wpte-popup-delete-button', function(){
        var id = $('#wpte_pm_license_id').val();
        var action = 'wpte_license_delete';
        var This = $(this);

        if(confirm("Are you sure you want to delete this?")){
            wpte_pm_delete( id, action,  This);
        }else{
            return false;
        }
    });

    // Plugin Delete
    $(document).on('click', '.wpte-plugin-delete-button', function(){
        var id = $('#wpte_plugin_id').val();
        var action = 'wpte_plugin_delete';
        var This = $(this);

        if(confirm("Are you sure you want to delete this?")){
            wpte_pm_delete( id, action,  This);
        }else{
            return false;
        }
    });



})(jQuery);