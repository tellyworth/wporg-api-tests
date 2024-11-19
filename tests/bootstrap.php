<?php

// autoload
require_once dirname( __DIR__ ) . '/vendor/autoload.php';

# Set proxy here
#define( 'WP_PROXY_HOST', '127.0.0.1' );
#define( 'WP_PROXY_PORT', '8080' );

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
if ( in_array( '--verbose', $_SERVER['argv'] ) ) {
	define( 'WP_DEBUG', true );
	define( 'WP_DEBUG_DISPLAY', true );
	define( 'WP_DEBUG_LOG', true );

	add_action( 'http_api_debug', function( $response, $type, $class, $args, $url ) {
		fwrite( STDERR, "http_api_debug\n" );
		fwrite( STDERR, print_r( $response, true ) );
		fwrite( STDERR, print_r( $type, true ) );
		fwrite( STDERR, print_r( $class, true ) );
		fwrite( STDERR, print_r( $args, true ) );
		fwrite( STDERR, print_r( $url, true ) );
	}, 10, 5 );

	// do_action_ref_array( "requests-{$hook}", $parameters, $this->request, $this->url );
	// $options['hooks']->dispatch('requests.before_parse', [&$response, $url, $headers, $data, $type, $options]);
	add_action( 'all', function( $hook, $parameters) {
		if ( str_starts_with( current_action(), 'requests-' ) ) {
			fwrite( STDERR, current_action() . "\n" );
			fwrite( STDERR, print_r( $parameters, true ) );
			#var_dump( debug_backtrace(0, 5) );
			#fwrite( STDERR, var_export( func_get_args(), true ) );
			#fwrite( STDERR, var_export( $parameters, true ) );
		}
	}, 10, 3 );
}