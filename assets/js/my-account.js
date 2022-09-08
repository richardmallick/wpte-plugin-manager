jQuery( document ).ready( function () {

    jQuery( '.license-toggle-info' ).click( function () {
        var parent = jQuery( this ).parents( '.wpte-license' );
        var showingInfo = parent.data('showing');

        if ( showingInfo == 1 ) {
            parent.find( '.license-key-activations' ).hide();
            jQuery( this ).removeClass( 'license-button-toggled' );
            parent.data( 'showing', 0 );
        } else {
            parent.find( '.license-key-activations' ).show();
            jQuery( this ).addClass( 'license-button-toggled' );
            parent.data( 'showing', 1 );
        }
    } );

    jQuery( 'a.remove-activation-button' ).click( function ( event ) {
        event.preventDefault();
        var aTag = jQuery( this );
        var isRemove = confirm("Are you want to remove this activation?");

        var data = {
            action: "wpte_remove_domain",
            domain_id: aTag.data('activationid'),
            license_id: aTag.data('licenseid'),
            security: wpteMyAc.ajaxNonce,
        };

        if ( isRemove ) {
            jQuery.ajax({
                method: "POST",
                data: data,
                url: wpteMyAc.ajaxUrl,
                success: function ( response ) {
                    if ( response.success ) {
                        aTag.parents('.wpte-activation-item').hide();
                        alert(response.data.success);
                    } else {
                        alert("Unable to remove site.");
                    }
                },
                error: function ( xhr, status, errors ) {
                    alert("Unable to remove site.");
                }
            });
        }
    });

    jQuery('.license-key-code').on('click', function( event ) {
        const el = document.createElement("textarea");
        el.value = jQuery(this).text();
        document.body.appendChild(el);
        el.select();
        el.setSelectionRange(0, 99999); // Mobile compatibility
        document.execCommand("copy");
        document.body.removeChild(el);
        jQuery(this).next('.tooltiptext').text("Copied!");
    });

    jQuery('.license-key-code').on('mouseout mouseleave', function() {
        jQuery(this).next('.tooltiptext').text("Click to Copy");
    });

    jQuery('.wpte-licenses .license-toggle-info').first().click();

} );
