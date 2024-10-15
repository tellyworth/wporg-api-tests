<?php

// autoload
require_once dirname( __DIR__ ) . '/vendor/autoload.php';

// load WordPress if we're running within wp-now.
if ( false !== strpos( $_SERVER['_'], '@wp-now/wp-now' ) ) {
	require_once '/var/www/html/wp-load.php';
}

if ( !function_exists( 'mb_split' ) ) {
	function mb_split( $pattern, $string, $limit = -1 ) {
		return preg_split( "/$pattern/u", $string, $limit );
	}
}

// Debugging; remove?
false && add_action( 'http_api_debug', function( $response, $type, $class, $args, $url ) {
	fwrite( STDERR, "http_api_debug\n" );
	fwrite( STDERR, print_r( $response, true ) );
	fwrite( STDERR, print_r( $type, true ) );
	fwrite( STDERR, print_r( $class, true ) );
	fwrite( STDERR, print_r( $args, true ) );
	fwrite( STDERR, print_r( $url, true ) );
}, 10, 5 );