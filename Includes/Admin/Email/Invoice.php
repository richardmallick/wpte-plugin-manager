<?php

namespace WPTE_PM_MANAGER\Includes\Admin\Email;

/**
 * Invoice Trait
 * 
 * @since 1.0.0
 */
trait Invoice{

  public function wpte_invoice( $id ) {

    $license = wpte_get_product_license_row( $id ) ? wpte_get_product_license_row( $id ) : (object)[];
    $license_key = $license->license_key ? $license->license_key : '';
    $product_name = $license->product_name ? $license->product_name : '';
    $activation_limit = $license->activation_limit ? $license->activation_limit : '';
    $created_date = $license->created_date ? $license->created_date : '';

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
                        <a href="https://wppool.dev/whatsapp-stock-notifier-for-woocommerce" style="text-decoration: none; " target="_blank">
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
                                      Md Sajjadul Islam
                                    </strong>,
                                    </p>
                                    <p style="font-family: Avenir, Helvetica, sans-serif;box-sizing: border-box;color: #74787e;font-size: 16px;line-height: 1.5em; margin-top: 0;text-align: left;margin-bottom: 0px;">
                                      Thank you for purchasing
                                      <strong style="font-family: Avenir, Helvetica,sans-serif;box-sizing: border-box;">Stock Notifier for WooCommerce Premium</strong>. Your order details are shown below for your reference.
                                    </p>
                                  </div>
                                  <div style="font-family: Avenir, Helvetica, sans-serif;box-sizing:border-box;padding: 0 30px 30px 30px;">
                                    <h2 style="font-family: Avenir, Helvetica, sans-serif;box-sizing: border-box;color: #707070;font-size: 19px;font-weight: bold;margin-top: 0;margin-bottom: 3px;text-align: left;">Order Details</h2>
                                    <p style="font-family: Avenir, Helvetica, sans-serif; box-sizing:border-box;color: #74787e;line-height: 1.5em;margin-top: 0;text-align: left;font-size: 15px; margin-bottom: 15px;">Ordered on
                                      <strong style="font-family: Avenir, Helvetica,sans-serif;box-sizing: border-box;">May 25, 2022</strong>
                                    </p>
                                    <table style="font-family: Avenir, Helvetica, sans-serif;box-sizing: border-box;margin: 0;width: 100%;border: 1px solid #c5d1db;padding: 4px;">
                                      <tbody>
                                        <tr>
                                          <td style="font-family: Avenir, Helvetica,sans-serif;box-sizing: border-box;width: 68%;">
                                            <table style="font-family: Avenir, Helvetica,sans-serif;box-sizing: border-box;">
                                              <tbody>
                                                <tr>
                                                  <td style="font-family: Avenir,Helvetica, sans-serif;box-sizing: border-box;min-width: 50px;max-width: 60px;">
                                                    <img alt="" style="font-family: Avenir,Helvetica, sans-serif;box-sizing: border-box;max-width: 100%;border-radius: 50%;" />
                                                  </td>
                                                  <td style="font-family: Avenir,Helvetica, sans-serif;box-sizing: border-box;padding-left: 8px;">
                                                    <h3 style="font-family: Avenir,Helvetica, sans-serif;box-sizing: border-box;color: #55555b;font-size: 16px;font-weight: bold;margin-top: 0;text-align: left;margin-bottom: 0px;
                                                        ">
                                                      <a href="https://wppool.dev/whatsapp-stock-notifier-for-woocommerce"
                                                        style="font-family: Avenir,Helvetica, sans-serif;box-sizing: border-box;text-decoration: none;color: #55555b;margin-bottom: 5px;" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://wppool.dev/whatsapp-stock-notifier-for-woocommerce&amp;source=gmail&amp;ust=1656507064627000&amp;usg=AOvVaw3YtTAmXOMk0nQn1rjmOMpK">Stock Notifier for WooCommerce Premium</a>
                                                    </h3>
                                                    <p style="font-family: Avenir,Helvetica, sans-serif;box-sizing: border-box;color: #74787e;font-size: 16px;line-height: 1.5em; margin-top: 0;text-align: left;margin-bottom: 0px;">
                                                      SNW Pro yearly
                                                    </p>
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </td>
                                          <td style=" font-family: Avenir, Helvetica,sans-serif;box-sizing: border-box;width: 32%;">
                                            <h3 style="font-family: Avenir, Helvetica,sans-serif;box-sizing: border-box;color: #55555b;font-size: 16px; font-weight: bold; margin-top: 0; margin-bottom: 0px; text-align: right; ">
                                              $99
                                            </h3>
                                            <p style="font-family: Avenir, Helvetica,sans-serif; box-sizing: border-box;color: #74787e;font-size: 16px;line-height: 1.5em;margin-top: 0;margin-bottom: 0px;text-align: right;">
                                              Renews every year
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
                                      <strong style=" font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; ">Stock Notifier for WooCommerce	Premium</strong>
                                      on your website.
                                    </p>
                                    <p style="font-family: Avenir, Helvetica, sans-serif;box-sizing: border-box;font-size: 16px; line-height: 1.5em;margin-top: 0; background: #f4f4f4; padding: 7px; color: #707070;text-align: center; margin-bottom: 15px;">
                                      4aacb719-207a-4769-a9cc-<wbr />0cf9f6d341de
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
                                              5
                                            </h3>
                                          </td>
                                          <td style="font-family: Avenir, Helvetica,sans-serif; box-sizing: border-box;width: 60px;"></td>
                                          <td style=" font-family: Avenir, Helvetica,sans-serif;box-sizing: border-box;border: 1px solid #c5d1db; padding: 10px;">
                                            <p style="font-family: Avenir, Helvetica,sans-serif; box-sizing: border-box; color: #74787e;font-size: 16px;line-height: 1.5em; margin-top: 0; text-align: center; margin-bottom: 5px; ">
                                              Expire Date
                                            </p>
                                            <h3 style="font-family: Avenir, Helvetica, sans-serif;box-sizing: border-box;color: #55555b;font-size: 16px;font-weight: bold; margin-top: 0;margin-bottom: 0px;text-align: center;">
                                              May 25, 2023
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
                                      <a href="https://wppool.dev/my-account/" style="font-family: Avenir, Helvetica,sans-serif;box-sizing: border-box;color: #3097d1; text-decoration: none;font-weight: bold;" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://wppool.dev/my-account/&amp;source=gmail&amp;ust=1656507064627000&amp;usg=AOvVaw2ygcinWJUG7iq6tHJCFf75">account</a>
                                      page to download the plugin and related invoices.
                                    </p>
                                    <table style="font-family: Avenir, Helvetica, sans-serif;box-sizing: border-box;margin: 0; padding: 0;width: 100%;">
                                      <tbody>
                                        <tr>
                                          <td style="font-family: Avenir, Helvetica, sans-serif;box-sizing: border-box; text-align: center;">
                                            <a href="https://api.appsero.com/update/a0f4d3da-e342-420b-8b38-1c2dc76aa2ee/download?key=4aacb719-207a-4769-a9cc-0cf9f6d341de&amp;validity=eyJpdiI6ImErNWpqd2FCZVpiN2F2OFZjNUdrc2c9PSIsInZhbHVlIjoiQzQ1dFpZQ0hZWWRkc0ErOW1KR3hSOFEyTmxNOXZxWGJvdEYwR0UvNmNUMD0iLCJtYWMiOiI4MjRjNjQ4MDJkZDU2ODgwZDVkODk5OGI2M2NlY2VlZTBlYmNmYjVhMmVjZGI5YWI4ZGUyOWZjMjJkNGMwNWNjIn0%3D"
                                              style=" font-family: Avenir, Helvetica,sans-serif;box-sizing: border-box;border-radius: 3px;color: #fff; display: inline-block;text-decoration: none; font-size: 16px; background: #3097d1; border-top: 10px solid #3097d1;border-right: 18px solid #3097d1;border-bottom: 10px solid #3097d1; border-left: 18px solid #3097d1;" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://api.appsero.com/update/a0f4d3da-e342-420b-8b38-1c2dc76aa2ee/download?key%3D4aacb719-207a-4769-a9cc-0cf9f6d341de%26validity%3DeyJpdiI6ImErNWpqd2FCZVpiN2F2OFZjNUdrc2c9PSIsInZhbHVlIjoiQzQ1dFpZQ0hZWWRkc0ErOW1KR3hSOFEyTmxNOXZxWGJvdEYwR0UvNmNUMD0iLCJtYWMiOiI4MjRjNjQ4MDJkZDU2ODgwZDVkODk5OGI2M2NlY2VlZTBlYmNmYjVhMmVjZGI5YWI4ZGUyOWZjMjJkNGMwNWNjIn0%253D&amp;source=gmail&amp;ust=1656507064627000&amp;usg=AOvVaw1L6BvSWsX8U_YHblkklkei">Download</a>
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
                                <a href="https://wppool.dev/whatsapp-stock-notifier-for-woocommerce"
                                  style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;color: #3097d1; text-decoration: none;font-weight: bold;" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://wppool.dev/whatsapp-stock-notifier-for-woocommerce&amp;source=gmail&amp;ust=1656507064627000&amp;usg=AOvVaw3YtTAmXOMk0nQn1rjmOMpK">WPTOFFEE</a>,
                              
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
        <div class="yj6qo"></div>
        <div class="adL"></div>
      </div>
    <?php
    $data = ob_get_clean();
    return $data;
  }
}
