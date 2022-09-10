<?php
$plugin_id = isset($_GET['id']) ? $_GET['id'] : '';

$plugin = wpte_pm_get_plugin( $plugin_id ) ? wpte_pm_get_plugin( $plugin_id ) : (object)[];

$site_url = site_url();
$url = explode('.', parse_url($site_url, PHP_URL_HOST));
?>

<code>
    require_once __DIR__ . "/client/Client.php";
</code>
<br>
<br>
<br>
<code>
    $client = new Wptoffee\Client('<?php echo esc_url($site_url); ?>', '<?php echo esc_html($url[0]); ?>', '<?php echo esc_html($plugin->plugin_key); ?>', 'Your Plugin Name', __FILE__);<br>
    $client->updater();
</code>
