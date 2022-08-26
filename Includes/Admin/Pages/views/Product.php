<?php
    $plugin_id = isset($_GET['id']) ? $_GET['id'] : '';

    $product = wpte_get_product( $plugin_id ) ? wpte_get_product( $plugin_id ) : (object)[];

    $recurring_periods = [
        'Days',
        'Months',
        'Years'
    ];

    $variations = wpte_get_product_variations( $plugin_id ) ? wpte_get_product_variations( $plugin_id ) : [];
    $variation_name_count = count($variations);

?>
<div class="wpte-pm-product-wrapper">
    <div class="wpte-pm-popup-inner">
        <form id="wpte-pm-product-form" action="" method="post">
            <input type="hidden" id="wpte_plugin_id" name="wpte_plugin_id" value="<?php echo intval($plugin_id); ?>">
            <input type="hidden" id="wpte_plugin_name_count" value="<?php echo intval($variation_name_count); ?>">
            <p class="wpte-pm-input-checkbox wpte-pm-input-checkbox-inline">
                <?php 
                $is_variation_checked = $product->is_variation ? 'checked' : '';
                ?>
                <span>This Plugin has variation</span>
                <input type="checkbox" id="wpte_pm_is_variation" name="wpte_pm_is_variation" <?php echo esc_attr($is_variation_checked); ?> />
                <label for="wpte_pm_is_variation"></label>
                
            </p>
            <div id="wpte_pm_product_variable">
                <div class="wpte-pm-variable-product-data">
                    <div class="wpte-pm-variable-product-options">
                        <?php 
                        if( $variations ):
                            $i = 0;
                            foreach ( $variations as $variation) {

                                $atchment = $variation->variation_file ? wp_get_attachment_url($variation->variation_file) : '';

                                $active = $i == 0 ? 'wpte-pm-active' : '';
                                $variation_id = $variation->id ? $variation->id : '';
                                ?>
                                    <div class="wpte-pm-variable-product-area">
                                    <input type="hidden" class="product_variation_id" name="product_variation_id[]" value="<?php echo $variation_id ?>">
                                    <input type="hidden" class="product_variation_id_remove" name="product_variation_id_remove[]" value="">
                                        <div class="wpte-pm-variable-product-header <?php echo $active; ?>">
                                            <div class="wpte-pm-variable-product-name">
                                            <?php echo esc_attr($variation->variation_name); ?>
                                            </div>
                                            <div class="wpte-pm-variable-product-remove-button">
                                            ╳
                                            </div>
                                        </div>
                                        <div class="wpte-pm-variable-product-content" style="display:none">
                                            <div class="wpte-pm-variable-product-content-inner">
                                                <div class="wpte-pm-variable wpte-pm-varition-name">
                                                    <div class="wpte-pm-input-wrapper">
                                                        <div>
                                                            <label for="wpte_pm_variation_name">Variation Name:</label>
                                                            <input type="text" id="wpte_pm_variation_name" name="wpte_pm_variation_name[]" value="<?php echo esc_attr($variation->variation_name); ?>">
                                                        </div>
                                                        
                                                        <div>
                                                            <label for="wpte_pm_variation_path">Product Path:</label>
                                                            <input type="text" id="wpte_pm_variation_path" name="wpte_pm_variation_path[]" value="<?php echo esc_attr($variation->variation_slug); ?>">
                                                        </div>
                                                        
                                                        <div>
                                                            <label for="wpte_pm_variation_price">Price:</label>
                                                            <input type="number" id="wpte_pm_variation_price" name="wpte_pm_variation_price[]" value="<?php echo esc_attr($variation->variation_price); ?>">
                                                        </div>
                                                    </div>

                                                    <div class="wpte-pm-input-wrapper wpte-pm-input-wrapper-middle">
                                                        <div>
                                                            <label for="wpte_pm_variation_activation_limit">Activation Limit:</label>
                                                            <input type="number" id="wpte_pm_variation_activation_limit" name="wpte_pm_variation_activation_limit[]" value="<?php echo esc_attr($variation->activation_limit); ?>">
                                                        </div>

                                                    </div>
                                                    
                                                    <div class="wpte-pm-input-wrapper">
                                                        <div class="wpte-pm-input-checkbox">
                                                            <?php $checked = $variation->recurring_payment == '1' ? 'checked' : '' ?>
                                                            <p>Recurring Payment:</p>
                                                            <input type="hidden" name="wpte_pm_variation_recurring_payment[]" value="0" />
                                                            <input <?php echo esc_attr($checked); ?> type="checkbox" id="wpte_pm_variation_recurring_payment-<?php echo $i; ?>" name="wpte_pm_variation_recurring_payment[]" value="1">
                                                            <label for="wpte_pm_variation_recurring_payment-<?php echo $i; ?>"></label>
                                                        </div>

                                                        <div>
                                                            <label for="wpte_pm_variation_recurring_period">Recurring Period:</label>
                                                            <select name="wpte_pm_variation_recurring_period[]" id="wpte_pm_variation_recurring_period" value="<?php echo esc_attr($variation->recurring_period); ?>">
                                                                <?php 
                                                                    foreach( $recurring_periods as $_recurring_period): 
                                                                        $active = strtolower($variation->recurring_period) == strtolower($_recurring_period) ? 'selected' : '';
                                                                ?>  
                                                                    <option <?php echo esc_attr($active); ?> value="<?php echo esc_attr($_recurring_period); ?>"><?php echo esc_html($_recurring_period); ?></option>
                                                                <?php endforeach; ?>
                                                            
                                                            </select>
                                                        </div>
                                                        
                                                        <div>
                                                            <label for="wpte_pm_variation_recurring_times">Times:</label>
                                                            <input type="number" id="wpte_pm_variation_recurring_times" name="wpte_pm_variation_recurring_times[]"  value="<?php echo esc_attr($variation->recurring_times); ?>">
                                                        </div>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                $i++;
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