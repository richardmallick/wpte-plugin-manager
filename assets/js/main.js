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
                    $('#wpte-add-plugin-loaders').removeClass('wpte-add-plugin-loader');
                    Swal.fire({
                        icon: 'success',
                        title: response.data.updated,
                        showConfirmButton: false,
                        timer: 2000,
                        padding: '2em',
                    })
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
            change_log: $('#wpte_pm_plugin_change_log').val(),
            file_id: $('.wpte-pm-file-id').val(),
            file_url: $('.wpte-pm-file-url').val(),
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
            change_log: $('#wpte_pm_plugin_change_log').val(),
            file_id: $('.wpte-pm-file-id').val(),
            file_url: $('.wpte-pm-file-url').val(),
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
                Swal.fire({
                    title: 'Saving...',
                    padding: '3em',
                    timerProgressBar: true,
                    didOpen: () => {
                      Swal.showLoading()
                    },
                  })
            },
            success: function (response) {
                Swal.fire(
                    'Saved!',
                    response.data.added,
                    'success',
                  ).then(() => {
                    location.reload();
                });

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
     * Delete License
     */
    function wpte_pm_delete( id, pluginid, action, This ) {
        $.ajax({
            type: 'POST',
            url: wptePlugin.ajaxUrl,
            data: {
                action: action,
                _nonce: wptePlugin.wpte_nonce,
                id: id,
                pluginid: pluginid,
            },
            beforeSend: function () {

                if ( action === 'wpte_plugin_delete' ) {
                    This.siblings('#wpte-add-plugin-loaders').addClass('wpte-add-plugin-loader');
                } else {
                    Swal.fire({
                        padding: '3em',
                        timerProgressBar: true,
                        didOpen: () => {
                          Swal.showLoading()
                        },
                      })
                }
                
            },
            success: function (response) {

                if ( typeof(response.data.deleted) != "undefined" && response.data.deleted !== null ) {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: response.data.deleted
                    }).then(() => {
                        $(location).attr('href', response.data.license_url);
                    });
                } else {
                    This.siblings('#wpte-add-plugin-loaders').removeClass('wpte-add-plugin-loader');
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: response.data.plugin_delete
                    }).then(() => {
                        $(location).attr('href', response.data.plugin_url);
                    });
                }

            },
            error: function (data) {
                console.log('error')
            }
        });
    }

    $(document).on('click', '#wpte-license-delete', function(){
        var id = $(this).attr('dataid');
        var pluginid = $(this).attr('pluginid');
        var action = 'wpte_license_delete';
        var This = $(this);

        Swal.fire({
            title: 'Are you sure?',
            text: "You can't revert it!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                wpte_pm_delete( id, pluginid, action,  This);
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                Swal.fire(
                'Cancelled',
                '',
                'error'
                )
            }
        }); 

    });

    // Plugin Delete
    $(document).on('click', '.wpte-plugin-delete-button', function(){
        var id = $('#wpte_plugin_id').val();
        var action = 'wpte_plugin_delete';
        var This = $(this);

        Swal.fire({
            title: 'Are you sure?',
            text: "You can't revert it!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                wpte_pm_delete( id, '', action,  This);
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                Swal.fire(
                'Cancelled',
                '',
                'error'
                )
            }
        }); 
    });

    $('.site-customer-name').on('mouseover', function(){
        $(this).find('.customer-name').show();
    })
    $('.site-customer-name').on('mouseleave', function(){
        $(this).find('.customer-name').hide();
    });

    // ============================== Domain Actions ===============================

    function wpte_license_actions(id, licenseid, action) {

        $.ajax({
            type: 'POST',
            url: wptePlugin.ajaxUrl,
            data: {
                action: action,
                _nonce: wptePlugin.wpte_nonce,
                id: id,
                licenseid:licenseid
            },
            beforeSend: function () {

                if ( action === 'wpte_license_update' ) {
                    $('#wpte-add-singe-license-loader').addClass('wpte-add-plugin-loader');
                } else {
                    Swal.fire({
                        padding: '3em',
                        timerProgressBar: true,
                        didOpen: () => {
                          Swal.showLoading()
                        },
                      })
                }
               
            },
            success: function (response) {

                if ( response.data.activation_updated ) {
                    setTimeout(function(){ 
                        location.reload()
                    }, 2000);
                    return;
                }
                if ( response.data.license_deactivate ) {
                    var message = response.data.license_deactivate;
                } else if( response.data.license_activate ){
                    var message = response.data.license_activate;
                }else if ( response.data.blocked ) {
                    var message = response.data.blocked;
                } else if ( response.data.inactive ) {
                    var message = response.data.inactive;
                } else {
                    Swal.fire(
                        response.data.deleted,
                        response.data.deleted_des,
                        'success',
                      ).then(() => {
                        location.reload();
                    });
                    return true;
                }
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: message
                }).then(() => {
                    location.reload();
                });
                
            },
            error: function (data) {
                console.log('error')
            }
        });
    }

    $('.wpte-site-block').on('click', function(e){
        var id = $(this).attr('dataid'),
            licenseid = $(this).attr('licenseid'),
            action = 'wpte_site_block';
            wpte_license_actions(id, licenseid, action);
    });

    $('.wpte-site-inactive').on('click', function(e){
        var id = $(this).attr('dataid'),
            licenseid = $(this).attr('licenseid'),
            action = 'wpte_site_inactive';
            wpte_license_actions(id, licenseid, action);
    });

    $('.wpte-site-delete').on('click', function(e){
        var id = $(this).attr('dataid'),
            licenseid = $(this).attr('licenseid'),
            action = 'wpte_site_delete';
              
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    wpte_license_actions(id, licenseid, action);
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    Swal.fire(
                    'Cancelled',
                    'Your domain is safe :)',
                    'error'
                    )
                }
            });   
    });

// ============================== Edit Single License ===============================

$('.wpte-pm-edit-button button').on('click', function(e){
    $('.wpte-pm-popup-wrapper').addClass('wpte-pm-popup-block');
    $('.wpte-pm-popup-box').slideDown() ;
});

$('#wpte_single_license_update').on('click', function(e){
    e.preventDefault();
    var licenseid = $('#wpte_pm_single_license_id').val(),
        action = 'wpte_license_update',
        data   = $('#wpte_pm_single_license_activation_limit').val();
        wpte_license_actions(data, licenseid, action);
});

$('#wpte-license-deactivate').on('click', function(e){
    e.preventDefault();
    var id = $(this).attr('dataid'),
        licenseid = $(this).attr('dataid'),
        action = 'wpte_license_deactivate';

        Swal.fire({
            title: 'Are you sure?',
            text: "This will deactive all site license key automatically!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, deactive!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                wpte_license_actions(id, licenseid, action);
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                Swal.fire(
                'Cancelled',
                '',
                'error'
                )
            }
        }); 
});

$('#wpte-license-active').on('click', function(e){
    e.preventDefault();
    var id = $(this).attr('dataid'),
        licenseid = $(this).attr('dataid'),
        action = 'wpte_license_activate';

        wpte_license_actions(id, licenseid, action);
});





})(jQuery);