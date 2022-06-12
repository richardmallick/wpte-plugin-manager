<?php
    $plugin_id = isset($_GET['id']) ? $_GET['id'] : '';

    $product = wpte_get_product( $plugin_id ) ? wpte_get_product( $plugin_id ) : '';

    $product_variation = $product->product_variation;
    $product_variation = json_decode($product_variation, true);

    $variation_name     = $product_variation['variation_name'] ? $product_variation['variation_name'] : [];
    $activation_limit   = $product_variation['activation_limit'] ? $product_variation['activation_limit'] : [];
    $variation_price    = $product_variation['variation_price'] ? $product_variation['variation_price'] : [];
    $variation_path     = $product_variation['variation_path'] ? $product_variation['variation_path'] : [];
    $recurring_payment  = $product_variation['recurring_payment'] ? $product_variation['recurring_payment'] : [];
    $recurring_period   = $product_variation['recurring_period'] ? $product_variation['recurring_period'] : [];
    $recurring_times    = $product_variation['recurring_times'] ? $product_variation['recurring_times'] : [];

    $recurring_periods = [
        'Days',
        'Months',
        'Years'
    ];

    $variation_name_count = count($variation_name);
    echo "<pre>";
        print_r($product);
    echo "</pre>";
?>
<div class="wpte-pm-product-wrapper">
    <div class="wpte-pm-popup-inner">
        <form id="wpte-pm-product-form" action="" method="post">
            <input type="hidden" id="wpte_plugin_id" name="wpte_plugin_id" value="<?php echo intval($plugin_id); ?>">
            <input type="hidden" id="wpte_plugin_name_count" value="<?php echo intval($variation_name_count); ?>">
            <div class="wpte-pm-popup-form-fields">
                <div class="wpte-pm-popup-form-field-left">
                    <label for="wpte_product_name">Product Name *</label>
                    <input type="text" id="wpte_product_name" name="wpte_product_name" value="<?php echo esc_html($product->product_name); ?>">
                    <p id="plugin-name"></p>
                </div>
                <div class="wpte-pm-popup-form-field-right">
                    <label for="wpte_product_slug">Product Slug *</label>
                    <input type="text" id="wpte_product_slug" name="wpte_product_slug" value="<?php echo esc_html($product->product_slug); ?>">
                    <p id="plugin-slug"></p>
                </div>
            </div>
            <br>
            <p>
                <input type="checkbox" id="wpte_pm_is_variation" name="wpte_pm_is_variation"/>
                <label for="wpte_pm_is_variation">This Plugin has variation</label>
            </p>
            <div id="wpte_pm_product_variable">
                <div class="wpte-pm-variable-product-data">
                    <div class="wpte-pm-variable-product-options">
                        <?php 
                        if( '' != $variation_name_count ):
                            for($i = 0; $i < $variation_name_count; $i++){

                               $active = $i == 0 ? 'wpte-pm-active' : '';

                                ?>
                                    <div class="wpte-pm-variable-product-area">
                                        <div class="wpte-pm-variable-product-header <?php echo $active; ?>">
                                            <div class="wpte-pm-variable-product-name">
                                            Product Layouts Pro
                                            </div>
                                            <div class="wpte-pm-variable-product-remove-button">
                                            ╳
                                            </div>
                                        </div>
                                        <div class="wpte-pm-variable-product-content" style="display:none">
                                            <div class="wpte-pm-variable-product-content-inner">
                                                <div class="wpte-pm-variable wpte-pm-varition-name">
                                                    <div>
                                                        <label for="wpte_pm_variation_name">Variation Name:</label>
                                                        <input type="text" id="wpte_pm_variation_name" name="wpte_pm_variation_name[]" value="<?php echo esc_html($variation_name[$i]); ?>">
                                                    </div>
                                                    
                                                   <div>
                                                        <label for="wpte_pm_variation_activation_limit">Activation Limit:</label>
                                                        <input type="text" id="wpte_pm_variation_activation_limit" name="wpte_pm_variation_activation_limit[]" value="<?php echo intval($activation_limit[$i]); ?>">
                                                   </div>
                                                    
                                                    <div>
                                                        <label for="wpte_pm_variation_price">Price:</label>
                                                        <input type="text" id="wpte_pm_variation_price" name="wpte_pm_variation_price[]" value="<?php echo esc_html($variation_price[$i]); ?>">
                                                    </div>

                                                    <div>
                                                        <label for="wpte_pm_variation_path">Product Path:</label>
                                                        <input type="text" id="wpte_pm_variation_path" name="wpte_pm_variation_path[]" value="<?php echo esc_html($variation_path[$i]); ?>">
                                                   </div>
                                                    
                                                    <div>
                                                        <?php $checked = $recurring_payment[$i] == '1' ? 'checked' : '' ?>
                                                        <label for="wpte_pm_variation_recurring_payment">Recurring Payment:</label>
                                                        <input type="hidden" name="wpte_pm_variation_recurring_payment[]" value="0" />
                                                        <input <?php echo esc_attr($checked); ?> type="checkbox" id="wpte_pm_variation_recurring_payment" name="wpte_pm_variation_recurring_payment[]" value="1">
                                                    </div>

                                                    <div>
                                                        <label for="wpte_pm_variation_recurring_period">Recurring Period:</label>
                                                        <select name="wpte_pm_variation_recurring_period[]" id="wpte_pm_variation_recurring_period" value="<?php echo esc_html($recurring_period[$i]); ?>">
                                                            <?php 
                                                                foreach( $recurring_periods as $_recurring_period): 
                                                                    $active = $recurring_period[$i] == $_recurring_period ? 'selected' : '';
                                                            ?>  
                                                                <option <?php echo esc_attr($active); ?> value="<?php echo esc_html($_recurring_period); ?>"><?php echo esc_html($_recurring_period); ?></option>
                                                            <?php endforeach; ?>
                                                           
                                                        </select>
                                                    </div>
                                                    
                                                    <div>
                                                        <label for="wpte_pm_variation_recurring_times">Times:</label>
                                                        <input type="number" id="wpte_pm_variation_recurring_times" name="wpte_pm_variation_recurring_times[]"  value="<?php echo esc_html($recurring_times[$i]); ?>">
                                                    </div>
                                                    <div>
                                                        <div id="wpte-pm-product-attachment-area">
                                                                <input type="hidden" class="wpte-pm-file-id" name="wpte_pm_file_id" value="">
                                                                <input type="text" class="wpte-pm-file-url" name="wpte_pm_file_url" value="">
                                                                <button id="wpte-pm-product-attachment" data-id="<?php echo $i; ?>">Choose File</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                            }
                        endif;
                        ?>

                    </div>
                    <div class="wpte-pm-variable-add-new-button">
                        <h2 id="wpte-pm-variable-add-field">＋ Add Field</h2>
                    </div>
                </div>
            </div>
            
            <div class="wpte-pm-popup-footer">
                <div class="wpte-footer-product-buttons">
                    <span id="wpte-add-plugin-loader" class="spinner sa-spinner-open"></span>
                    <input type="submit" class="wpte-product-save-button" name="wpte_product_form_submit" id="wpte_product_form_submit" value="Save">
                </div>
            </div>
        </form>
    </div>
</div>