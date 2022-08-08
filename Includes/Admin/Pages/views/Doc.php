<?php
$plugin_id = isset($_GET['id']) ? $_GET['id'] : '';

$plugin = wpte_pm_get_plugin( $plugin_id ) ? wpte_pm_get_plugin( $plugin_id ) : (object)[];



?>

<code>
    require_once __DIR__ . "/client/Client.php";
</code>
<br>
<br>
<br>
<code>
    $client = new Wptoffee\Client('<?php echo esc_html($plugin->plugin_key); ?>', 'Your Plugin Name', __FILE__);<br>
    $client->updater();
</code>
