<div class="wpte-pm-product-wrapper">
    <div class="wpte-pm-popup-inner">
        <form action="" method="post">
            <div class="wpte-pm-popup-form-fields">
                <div class="wpte-pm-popup-form-field-left">
                    <label for="wpte_product_name">Product Name *</label>
                    <input type="text" id="wpte_product_name" name="wpte_product_name">
                    <p id="plugin-name"></p>
                </div>
                <div class="wpte-pm-popup-form-field-right">
                    <label for="wpte_product_slug">Product Slug *</label>
                    <input type="text" id="wpte_product_slug" name="wpte_product_slug">
                    <p id="plugin-slug"></p>
                </div>
            </div>

            <div class="wpte-pm-footer-attachment">
                <div id="wpte-pm-product-attachment-area">
                        <input type="hidden" class="wpte-pm-file-id" name="wpte-pm-file-id" value="">
                        <input type="text" class="wpte-pm-file-url" name="wpte-pm-file-url" value="">
                        <button id="wpte-pm-product-attachment">Choose File</button>
                </div>
            </div>

            <br>
            <p><input type="checkbox" id="wpte_pm_is_variation" name="wpte_pm_is_variation"/>
                <label for="wpte_pm_is_variation">This Plugin has variation</label></p>










            <?php
                $kdIds = [1, 2, 3, 4, 5];
                $kdIdCount = 5; ?>
            <div id="wpte_pm_product_variable">
                <div class="wpte-pm-variable-product-data">
                    <div class="wpte-pm-variable-product-options">
                        <?php 
                        if( '' != $kdIds ):
                            foreach($kdIds as $key => $kdID){

                                $active = $key == 0 ? 'wpte-pm-active' : '';

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
                                                        <input type="checkbox" id="wpte_pm_variation_recurring_payment" name="wpte_pm_variation_recurring_payment[]">
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
                <div class="wpte-footer-buttons">
                    <span id="wpte-add-plugin-loader" class="spinner sa-spinner-open"></span>
                    <button type="button" class="wpte-popup-close-button">Close</button>
                    <input type="submit" class="wpte-popup-save-button" name="wpte_popup_form_submit" id="wpte_popup_form_submit" value="Save">
                </div>
            </div>
        </form>
    </div>
</div>