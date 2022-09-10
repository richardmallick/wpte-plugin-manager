<?php

namespace WPTE_PM_MANAGER\Includes\Admin\Email;

/**
 * Invoice Trait
 * 
 * @since 1.0.0
 */
trait Invoice{

  public function wpte_invoice( $id ) {

    $license = wpte_pm_get_data_for_invoice( $id ) ? wpte_pm_get_data_for_invoice( $id ) : (object)[];

    // Get User Data
    $customer_id    = $license->customer_id ? $license->customer_id : '';
    $customer       = get_user_by('id', $customer_id);
    $customer_name  = $customer->first_name . ' ' . $customer->last_name;

    // Get Plugin Data Plugin
    $plugin_name  = $license->plugin_name ? $license->plugin_name : '';
    $logo         = $license->logo_id ? wp_get_attachment_image_url($license->logo_id) : '';
    $demo_url     = $license->demo_url ? $license->demo_url : '';

    // Get Product Data
    $product_name   = $license->variation_name ? $license->variation_name : '';
    $product_price  = $license->variation_price ? $license->variation_price : 00;
    $file_id  = $license->file_id ? $license->file_id : '';

    // Get License
    $license_key      = $license->license_key ? $license->license_key : '';
    $activation_limit = $license->activation_limit ? $license->activation_limit : '';
    $_created_date    = current_time('mysql');
    $created_date     = date("M d, Y", strtotime($_created_date));

    if ( $license->expired_date !== 'lifetime' ) {
      $recurring_period = $license->recurring_period ? $license->recurring_period : '';
      $recurring_times  = $license->recurring_times ? $license->recurring_times : '';
      if ( $recurring_period === 'years' && $recurring_times == 1 ) {
        $renew = 'Renews every year';
      }else {
        $renew = 'Renews every '.$recurring_times.' '. ucfirst($recurring_period);
      }
      
    } else {
      $renew = 'Lifetime';
    }

    $_expired_date  = $license->expired_date ? $license->expired_date : ''; 
    $expired_date   = $_expired_date ? date("M d, Y", $_expired_date) : 'Lifetime';

    ob_start();
    ?>
      <div style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;background: #f3f3f3;color: #74787e;height: 100%;line-height: 1.4;margin: 0;width: 100% !important;word-break: break-word;">
        <table width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif;box-sizing: border-box;background: #f3f3f3;margin: 0;padding: 0;width: 100%;">
          <tbody>
            <tr>
              <td align="center" style="font-family: Avenir, Helvetica, sans-serif;box-sizing: border-box;">
                <table width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 0; padding: 0; width: 100%;">
                  <tbody>
                    <tr>
                      <td style="font-family: Avenir, Helvetica, sans-serif;box-sizing:border-box;padding: 25px 0;text-align: center;">
                        <a href="https://wptoffee.com" style="text-decoration: none; " target="_blank">
                          <img alt="WPTOFFEE" height="auto" style="max-width: 180px;height: auto;max-height: 100px;" />
                        </a>
                      </td>
                    </tr>

                    <tr>
                      <td width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif;box-sizing: border-box;margin: 0;padding: 0;width: 100%;">
                        <table align="center" width="570" cellpadding="0"cellspacing="0" style="font-family: Avenir,Helvetica, sans-serif;box-sizing: border-box;background: transparent;margin: 0 auto;padding: 0;width: 570px;">
                          <tbody>
                            <tr>
                              <td style="font-family: Avenir, Helvetica, sans-serif;box-sizing: border-box;border-top: 4px solid #7ba3f8;background: #ffffff;">
                                <div style=" font-family: Avenir, Helvetica, sans-serif;box-sizing: border-box;">
                                  <h1 style="font-family: Avenir, Helvetica, sans-serif;box-sizing: border-box;color: #707070;font-size: 25px;font-weight: bold;margin-top: 0;text-align: center;padding-top: 25px;padding-bottom: 25px;padding-left: 25px;padding-right: 25px;border-bottom: 2px solid #f3f3f3;margin-bottom: 20px;">
                                    Your order is complete
                                  </h1>
                                  <div style="font-family: Avenir,Helvetica,sans-serif;box-sizing: border-box;padding: 0 30px 30px 30px;">
                                    <p style="font-family: Avenir,Helvetica, sans-serif; box-sizing: border-box;color: #74787e;font-size: 16px;line-height: 1.5em; margin-top: 0;text-align: left;margin-bottom: 8px;">
                                      Dear
                                      <strong style="font-family: Avenir, Helvetica,sans-serif;box-sizing:border-box">
                                      <?php echo esc_html($customer_name); ?>
                                    </strong>,
                                    </p>
                                    <p style="font-family: Avenir, Helvetica, sans-serif;box-sizing: border-box;color: #74787e;font-size: 16px;line-height: 1.5em; margin-top: 0;text-align: left;margin-bottom: 0px;">
                                      Thank you for purchasing
                                      <strong style="font-family: Avenir, Helvetica,sans-serif;box-sizing: border-box;"><?php echo esc_html($plugin_name); ?></strong>. Your order details are shown below for your reference.
                                    </p>
                                  </div>
                                  <div style="font-family: Avenir, Helvetica, sans-serif;box-sizing:border-box;padding: 0 30px 30px 30px;">
                                    <h2 style="font-family: Avenir, Helvetica, sans-serif;box-sizing: border-box;color: #707070;font-size: 19px;font-weight: bold;margin-top: 0;margin-bottom: 3px;text-align: left;">Order Details</h2>
                                    <p style="font-family: Avenir, Helvetica, sans-serif; box-sizing:border-box;color: #74787e;line-height: 1.5em;margin-top: 0;text-align: left;font-size: 15px; margin-bottom: 15px;">Ordered on
                                      <strong style="font-family: Avenir, Helvetica,sans-serif;box-sizing: border-box;"><?php echo esc_html($created_date); ?></strong>
                                    </p>
                                    <table style="font-family: Avenir, Helvetica, sans-serif;box-sizing: border-box;margin: 0;width: 100%;border: 1px solid #c5d1db;padding: 4px;">
                                      <tbody>
                                        <tr>
                                          <td style="font-family: Avenir, Helvetica,sans-serif;box-sizing: border-box;width: 68%;">
                                            <table style="font-family: Avenir, Helvetica,sans-serif;box-sizing: border-box;">
                                              <tbody>
                                                <tr>
                                                  <td style="font-family: Avenir,Helvetica, sans-serif;box-sizing: border-box;min-width: 50px;max-width: 60px;">
                                                    <img alt="" src="<?php echo esc_url($logo); ?>" style="box-sizing: border-box;max-width: 100%;border-radius: 50%;" />
                                                  </td>
                                                  <td style="font-family: Avenir,Helvetica, sans-serif;box-sizing: border-box;padding-left: 8px;">
                                                    <h3 style="font-family: Avenir,Helvetica, sans-serif;box-sizing: border-box;color: #55555b;font-size: 16px;font-weight: bold;margin-top: 0;text-align: left;margin-bottom: 0px;
                                                        ">
                                                      <a href="<?php echo esc_url($demo_url); ?>"
                                                        style="font-family: Avenir,Helvetica, sans-serif;box-sizing: border-box;text-decoration: none;color: #55555b;margin-bottom: 5px;"><?php echo esc_html($plugin_name); ?></a>
                                                    </h3>
                                                    <p style="font-family: Avenir,Helvetica, sans-serif;box-sizing: border-box;color: #74787e;font-size: 16px;line-height: 1.5em; margin-top: 0;text-align: left;margin-bottom: 0px;">
                                                      <?php echo esc_html($product_name); ?>
                                                    </p>
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </td>
                                          <td style=" font-family: Avenir, Helvetica,sans-serif;box-sizing: border-box;width: 32%;">
                                            <h3 style="font-family: Avenir, Helvetica,sans-serif;box-sizing: border-box;color: #55555b;font-size: 16px; font-weight: bold; margin-top: 0; margin-bottom: 0px; text-align: right; ">
                                              $<?php echo esc_html($product_price); ?>
                                            </h3>
                                            <p style="font-family: Avenir, Helvetica,sans-serif; box-sizing: border-box;color: #74787e;font-size: 16px;line-height: 1.5em;margin-top: 0;margin-bottom: 0px;text-align: right;">
                                              <?php echo esc_html($renew); ?>
                                            </p>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div>
                                  <div style="font-family: Avenir, Helvetica, sans-serif;box-sizing: border-box;padding: 0 30px 30px 30px;">
                                    <h2 style=" font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #707070; font-size: 19px; font-weight: bold; margin-top: 0; margin-bottom: 3px; text-align: left;">
                                      License Information
                                    </h2>
                                    <p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left; margin-bottom: 15px;">
                                      Here is your license information. Please use
                                      following license to activate
                                      <strong style=" font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; "><?php echo esc_html($plugin_name); ?></strong>
                                      on your website.
                                    </p>
                                    <p style="font-family: Avenir, Helvetica, sans-serif;box-sizing: border-box;font-size: 16px; line-height: 1.5em;margin-top: 0; background: #f4f4f4; padding: 7px; color: #707070;text-align: center; margin-bottom: 15px;">
                                      <?php echo esc_html($license_key); ?>
                                    </p>
                                    <table style=" font-family: Avenir, Helvetica, sans-serif;box-sizing: border-box; margin: 0;padding: 0; width: 100%;
                                        ">
                                      <tbody>
                                        <tr>
                                          <td style=" font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; border: 1px solid #c5d1db; padding: 10px;">
                                            <p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e;font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: center; margin-bottom: 5px;">
                                              Activation limit
                                            </p>
                                            <h3 style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #55555b;font-size: 16px;font-weight: bold;margin-top: 0;margin-bottom: 0px;text-align: center;">
                                              <?php echo esc_html($activation_limit); ?>
                                            </h3>
                                          </td>
                                          <td style="font-family: Avenir, Helvetica,sans-serif; box-sizing: border-box;width: 60px;"></td>
                                          <td style=" font-family: Avenir, Helvetica,sans-serif;box-sizing: border-box;border: 1px solid #c5d1db; padding: 10px;">
                                            <p style="font-family: Avenir, Helvetica,sans-serif; box-sizing: border-box; color: #74787e;font-size: 16px;line-height: 1.5em; margin-top: 0; text-align: center; margin-bottom: 5px; ">
                                              Expire Date
                                            </p>
                                            <h3 style="font-family: Avenir, Helvetica, sans-serif;box-sizing: border-box;color: #55555b;font-size: 16px;font-weight: bold; margin-top: 0;margin-bottom: 0px;text-align: center;">
                                              <?php echo esc_html($expired_date); ?>
                                            </h3>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div>
                                  <div style=" font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 0 30px 30px 30px;
                                      ">
                                    <p style="font-family: Avenir, Helvetica, sans-serif;box-sizing: border-box;color: #74787e;font-size: 16px; line-height: 1.5em;margin-top: 0;text-align: left; margin-bottom: 15px;">
                                      You can download the plugin files by clicking the link below. Alternatively, go	to your
                                      <a href="https://wptoffee.com/my-account/" style="font-family: Avenir, Helvetica,sans-serif;box-sizing: border-box;color: #3097d1; text-decoration: none;font-weight: bold;" target="_blank" >account</a>
                                      page to download the plugin and related invoices.
                                    </p>
                                    <table style="font-family: Avenir, Helvetica, sans-serif;box-sizing: border-box;margin: 0; padding: 0;width: 100%;">
                                      <tbody>
                                        <tr>
                                          <td style="font-family: Avenir, Helvetica, sans-serif;box-sizing: border-box; text-align: center;">
                                            <a href="<?php echo site_url().'/download/?id='.intval($file_id).'&key='.esc_html($license_key); ?>" download
                                              style=" font-family: Avenir, Helvetica,sans-serif;box-sizing: border-box;border-radius: 3px;color: #fff; display: inline-block;text-decoration: none; font-size: 16px; background: #3097d1; border-top: 10px solid #3097d1;border-right: 18px solid #3097d1;border-bottom: 10px solid #3097d1; border-left: 18px solid #3097d1;">Download</a>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>

                    <tr>
                      <td style=" font-family: Avenir, Helvetica, sans-serif;box-sizing: border-box;">
                        <table align="center" width="570" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif;box-sizing: border-box;margin: 0 auto;padding: 0;text-align: center;width: 570px;">
                          <tbody>
                            <tr>
                              <td align="center" style="font-family: Avenir, Helvetica, sans-serif;box-sizing: border-box; color: #999;font-size: 14px;text-align: center;padding-top: 30px;padding-bottom: 30px; ">You’re receiving this email because you made a purchase at
                                <a href="https://wptoffee.com" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;color: #3097d1; text-decoration: none;font-weight: bold;" >WPTOFFEE</a>.
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
          </tbody>
        </table>
        <!-- <div class="yj6qo"></div>
        <div class="adL"></div> -->
      </div>
    <?php
    $data = ob_get_clean();
    return $data;
  }
}
