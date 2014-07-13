<?php

namespace Rarst\ComposePOT;

require __DIR__ . '/vendor/autoload.php';

if ( ! defined( 'PO_MAX_LINE_LEN' ) ) {
	define( 'PO_MAX_LINE_LEN', 79 );
}

ini_set( 'auto_detect_line_endings', 1 );

$app = new \Cilex\Application( 'ComposePOT' );

$app['makepot'] = function () {
	return new MakePOT();
};

$app['add_textdomain'] = function () {
	return new AddTextdomain();
};

$app->command( new Command\Extract_Strings() );
$app->command( new Command\Add_Domain() );

$app->run();