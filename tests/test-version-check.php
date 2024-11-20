<?php

use PHPUnit\Framework\TestCase;

class VersionCheckTest extends TestCase {
	public function testVersion() {
		// We can't just call `wp_version_check()` because it doesn't return anything. The docs don't state what it does.
		// Instead, we'll roll our own version check so we can see what the API returns.
		/*
		add_filter( 'core_version_check_query_args', function( $args ) {
			var_export( $args );
			return $args;
		} );
		wp_version_check([], true );
		*/

		$version_check_args = array (
			'version' => '6.6.2',
			'php' => '8.1.23-dev',
			'locale' => 'en_US',
			'mysql' => '3.40.1',
			'local_package' => '',
			'blogs' => 1,
			'users' => 1,
			'multisite_enabled' => 0,
			'initial_db_version' => '56657',
			'extensions' =>
			array (
			  'bcmath' => '8.1.23-dev',
			  'calendar' => '8.1.23-dev',
			  'Core' => '8.1.23-dev',
			  'ctype' => '8.1.23-dev',
			  'date' => '8.1.23-dev',
			  'dom' => '20031129',
			  'fileinfo' => '8.1.23-dev',
			  'filter' => '8.1.23-dev',
			  'gd' => '8.1.23-dev',
			  'hash' => '8.1.23-dev',
			  'iconv' => '8.1.23-dev',
			  'json' => '8.1.23-dev',
			  'libxml' => '8.1.23-dev',
			  'mbstring' => '8.1.23-dev',
			  'mysqli' => '8.1.23-dev',
			  'mysqlnd' => 'mysqlnd 8.1.23-dev',
			  'openssl' => '8.1.23-dev',
			  'pcre' => '8.1.23-dev',
			  'PDO' => '8.1.23-dev',
			  'pdo_mysql' => '8.1.23-dev',
			  'pdo_sqlite' => '8.1.23-dev',
			  'Phar' => '8.1.23-dev',
			  'readline' => '8.1.23-dev',
			  'Reflection' => '8.1.23-dev',
			  'session' => '8.1.23-dev',
			  'SimpleXML' => '8.1.23-dev',
			  'SPL' => '8.1.23-dev',
			  'sqlite3' => '8.1.23-dev',
			  'standard' => '8.1.23-dev',
			  'tokenizer' => '8.1.23-dev',
			  'wasm_memory_storage' => '0.0.1',
			  'xml' => '8.1.23-dev',
			  'xmlreader' => '8.1.23-dev',
			  'xmlwriter' => '8.1.23-dev',
			  'zip' => '1.19.5',
			  'zlib' => '8.1.23-dev',
			),
			'platform_flags' =>
			array (
			  'os' => 'Linux',
			  'bits' => 32,
			),
			'image_support' =>
			array (
			  'gd' =>
			  array (
			  ),
			),
		);

		$version_check_url = 'https://api.wordpress.org/core/version-check/1.7/?' . http_build_query( $version_check_args, '', '&' );

		$http_response = wp_remote_post( $version_check_url, [] );
		$response = json_decode( wp_remote_retrieve_body( $http_response ), true );

		$expected = array (
			0 =>
			array (
			  'response' => 'upgrade',
			  'download' => 'https://downloads.wordpress.org/release/wordpress-6.7.zip',
			  'locale' => 'en_US',
			  'packages' =>
			  array (
				'full' => 'https://downloads.wordpress.org/release/wordpress-6.7.zip',
				'no_content' => 'https://downloads.wordpress.org/release/wordpress-6.7-no-content.zip',
				'new_bundled' => 'https://downloads.wordpress.org/release/wordpress-6.7-new-bundled.zip',
				'partial' => false,
				'rollback' => false,
			  ),
			  'current' => '6.7',
			  'version' => '6.7',
			  'php_version' => '7.2.24',
			  'mysql_version' => '5.5.5',
			  'new_bundled' => '6.7',
			  'partial_version' => false,
			),
			1 =>
			array (
			  'response' => 'autoupdate',
			  'download' => 'https://downloads.w.org/release/wordpress-6.7.zip',
			  'locale' => 'en_US',
			  'packages' =>
			  array (
				'full' => 'https://downloads.w.org/release/wordpress-6.7.zip',
				'no_content' => 'https://downloads.w.org/release/wordpress-6.7-no-content.zip',
				'new_bundled' => 'https://downloads.w.org/release/wordpress-6.7-new-bundled.zip',
				'partial' => false,
				'rollback' => false,
			  ),
			  'current' => '6.7',
			  'version' => '6.7',
			  'php_version' => '7.2.24',
			  'mysql_version' => '5.5.5',
			  'new_bundled' => '6.7',
			  'partial_version' => false,
			  'new_files' => true,
			),
		);

		$this->assertIsArray( $response );
		$this->assertArrayHasKey( 'offers', $response );
		$this->assertIsArray( $response['offers'] );

		// The response will change with each release, will probably need to adjust this a bit to suit.
		$this->assertContains( $expected[0], $response['offers'] );
		$this->assertContains( $expected[1], $response['offers'] );

	}

}