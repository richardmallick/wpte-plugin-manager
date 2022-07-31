<?php 

$update = array(
	"name" => "Product Layouts Pro",
	"slug" => "product-layouts-pro",
	"plugin" => "",
	"url" => "",
	"icons" => [
		'1x' => '',
		'2x' => '',
	],
	"banners"  => [
        "low"  => "",
		"high"  => ""
    ],
	"tested"  => "6.0",
	"requires_php"  => "5.6",
	"requires"  => "5.4",
	"download_url"  => "http://myplugin.test/wp-content/uploads/2022/07/product-layouts-pro.zip",
	"sections"  => [
        "description"  => "This is woocommerce product layout plugin. you can design product using this plugin for your woocommerce store.",
		"installation"  => "Click the activate button and that's it.",
		"changelog"  => "<h3>1.0 –  1 august 2021</h3><ul><li>Bug fixes.</li><li>Initital release.</li></ul>"
    ],
	'new_version' => '2.0.3',
	"last_updated"  => "2022-06-30 02:10:00",
	
);

header( 'Content-Type: application/json' );
echo json_encode( $update );

?>