<?php

use PHPUnit\Framework\TestCase;

// Simple test cases for GET requests on older APIs.

class TestSimpleAPIs extends TestCase {

	public static function simple_api_provider() {
		// See https://codex.wordpress.org/WordPress.org_API

		return [
			[ 'https://api.wordpress.org/secret-key/1.0/' ],
			[ 'https://api.wordpress.org/secret-key/1.1/' ],
			[ 'https://api.wordpress.org/secret-key/1.1/salt/' ],
			[ 'https://api.wordpress.org/stats/wordpress/1.0/' ],
			[ 'https://api.wordpress.org/stats/php/1.0/' ],
			[ 'https://api.wordpress.org/stats/mysql/1.0/' ],
			[ 'https://api.wordpress.org/stats/locale/1.0/' ],
			[ 'https://api.wordpress.org/stats/plugin/1.0/hello-holly' ],
			[ 'https://api.wordpress.org/stats/plugin/1.0/downloads.php?slug=hello-dolly&limit=7&callback=' ],
			[ 'https://api.wordpress.org/core/version-check/1.6/' ],
			[ 'https://api.wordpress.org/core/version-check/1.7/' ],


			[ 'https://api.wordpress.org/core/credits/1.0/' ],
			[ 'https://api.wordpress.org/core/credits/1.1/?version=6.6&locale=en_US' ],

			[ 'https://api.wordpress.org/translations/core/1.0/?version=6.6' ],
			[ 'https://api.wordpress.org/translations/plugins/1.0/?slug=hello-dolly&version=9.9' ],
			[ 'https://api.wordpress.org/translations/themes/1.0/?slug=twentytwentyfour&version=9.9' ],
			[ 'https://api.wordpress.org/plugins/info/1.0/hello-dolly' ],
			[ 'https://api.wordpress.org/plugins/info/1.0/hello-dolly.json' ],
			//[ 'https://api.wordpress.org/plugins/update-check/1.0/' ],
			//[ 'https://api.wordpress.org/plugins/update-check/1.1/' ],
		];
	}

	/**
	 * @dataProvider simple_api_provider
	 */
	public function test_simple_api( $url ) {

		// This just runs a few crude checks on APIs:
		// - Check for a 200 response.
		// - Check for a non-empty body.
		// - Check for valid json if it looks like json.
		// - Check for valid serialized data.

		$response = wp_remote_get( $url );

		$this->assertEquals( 200, wp_remote_retrieve_response_code( $response ) );

		$body = wp_remote_retrieve_body( $response );
		$this->assertNotEmpty( $body );
		#$this->assertNotEquals( 'error', $body );

		// Check for valid json if it looks like json.
		if ( str_starts_with( $body, '{' ) || str_starts_with( wp_remote_retrieve_header( $response, 'content-type' ), 'application/json' ) ) {
			$data = json_decode( $body, true, 99, JSON_THROW_ON_ERROR );
			#var_dump( $data );
			$this->assertTrue( is_array( $data ) );
			$this->assertStringStartsWith( 'application/json', wp_remote_retrieve_header( $response, 'content-type' ) );
		}

		// Check for validity if it looks serialized
		if ( str_starts_with( $body, 'a:' ) ) {
			$data = unserialize( $body );
			$this->assertTrue( is_array( $data ) );
		}

		#var_dump( $url, $body );
	}

	public function test_core_stable_check() {
		$expected = <<<JSON
{
	"1.0.2" : "insecure",
	"1.2.1" : "insecure",
	"1.2.2" : "insecure",
	"1.5.1" : "insecure",
	"1.5.1.1" : "insecure",
	"1.5.1.2" : "insecure",
	"1.5.1.3" : "insecure",
	"1.5.2" : "insecure",
	"2.0" : "insecure",
	"2.0.1" : "insecure",
	"2.0.4" : "insecure",
	"2.0.5" : "insecure",
	"2.0.6" : "insecure",
	"2.0.7" : "insecure",
	"2.0.8" : "insecure",
	"2.0.9" : "insecure",
	"2.0.10" : "insecure",
	"2.0.11" : "insecure",
	"2.1" : "insecure",
	"2.1.1" : "insecure",
	"2.1.2" : "insecure",
	"2.1.3" : "insecure",
	"2.2" : "insecure",
	"2.2.1" : "insecure",
	"2.2.2" : "insecure",
	"2.2.3" : "insecure",
	"2.3" : "insecure",
	"2.3.1" : "insecure",
	"2.3.2" : "insecure",
	"2.3.3" : "insecure",
	"2.5" : "insecure",
	"2.5.1" : "insecure",
	"2.6" : "insecure",
	"2.6.1" : "insecure",
	"2.6.2" : "insecure",
	"2.6.3" : "insecure",
	"2.6.5" : "insecure",
	"2.7" : "insecure",
	"2.7.1" : "insecure",
	"2.8" : "insecure",
	"2.8.1" : "insecure",
	"2.8.2" : "insecure",
	"2.8.3" : "insecure",
	"2.8.4" : "insecure",
	"2.8.5" : "insecure",
	"2.8.6" : "insecure",
	"2.9" : "insecure",
	"2.9.1" : "insecure",
	"2.9.2" : "insecure",
	"3.0" : "insecure",
	"3.0.1" : "insecure",
	"3.0.2" : "insecure",
	"3.0.3" : "insecure",
	"3.0.4" : "insecure",
	"3.0.5" : "insecure",
	"3.0.6" : "insecure",
	"3.1" : "insecure",
	"3.1.1" : "insecure",
	"3.1.2" : "insecure",
	"3.1.3" : "insecure",
	"3.1.4" : "insecure",
	"3.2" : "insecure",
	"3.2.1" : "insecure",
	"3.3" : "insecure",
	"3.3.1" : "insecure",
	"3.3.2" : "insecure",
	"3.3.3" : "insecure",
	"3.4" : "insecure",
	"3.4.1" : "insecure",
	"3.4.2" : "insecure",
	"3.5" : "insecure",
	"3.5.1" : "insecure",
	"3.5.2" : "insecure",
	"3.6" : "insecure",
	"3.6.1" : "insecure",
	"3.7" : "insecure",
	"3.7.1" : "insecure",
	"3.7.2" : "insecure",
	"3.7.3" : "insecure",
	"3.7.4" : "insecure",
	"3.7.5" : "insecure",
	"3.7.6" : "insecure",
	"3.7.7" : "insecure",
	"3.7.8" : "insecure",
	"3.7.9" : "insecure",
	"3.7.10" : "insecure",
	"3.7.11" : "insecure",
	"3.7.12" : "insecure",
	"3.7.13" : "insecure",
	"3.7.14" : "insecure",
	"3.7.15" : "insecure",
	"3.7.16" : "insecure",
	"3.7.17" : "insecure",
	"3.7.18" : "insecure",
	"3.7.19" : "insecure",
	"3.7.20" : "insecure",
	"3.7.21" : "insecure",
	"3.7.22" : "insecure",
	"3.7.23" : "insecure",
	"3.7.24" : "insecure",
	"3.7.25" : "insecure",
	"3.7.26" : "insecure",
	"3.7.27" : "insecure",
	"3.7.28" : "insecure",
	"3.7.29" : "insecure",
	"3.7.30" : "insecure",
	"3.7.31" : "insecure",
	"3.7.32" : "insecure",
	"3.7.33" : "insecure",
	"3.7.34" : "insecure",
	"3.7.35" : "insecure",
	"3.7.36" : "insecure",
	"3.7.37" : "insecure",
	"3.7.38" : "insecure",
	"3.7.39" : "insecure",
	"3.7.40" : "insecure",
	"3.7.41" : "insecure",
	"3.8" : "insecure",
	"3.8.1" : "insecure",
	"3.8.2" : "insecure",
	"3.8.3" : "insecure",
	"3.8.4" : "insecure",
	"3.8.5" : "insecure",
	"3.8.6" : "insecure",
	"3.8.7" : "insecure",
	"3.8.8" : "insecure",
	"3.8.9" : "insecure",
	"3.8.10" : "insecure",
	"3.8.11" : "insecure",
	"3.8.12" : "insecure",
	"3.8.13" : "insecure",
	"3.8.14" : "insecure",
	"3.8.15" : "insecure",
	"3.8.16" : "insecure",
	"3.8.17" : "insecure",
	"3.8.18" : "insecure",
	"3.8.19" : "insecure",
	"3.8.20" : "insecure",
	"3.8.21" : "insecure",
	"3.8.22" : "insecure",
	"3.8.23" : "insecure",
	"3.8.24" : "insecure",
	"3.8.25" : "insecure",
	"3.8.26" : "insecure",
	"3.8.27" : "insecure",
	"3.8.28" : "insecure",
	"3.8.29" : "insecure",
	"3.8.30" : "insecure",
	"3.8.31" : "insecure",
	"3.8.32" : "insecure",
	"3.8.33" : "insecure",
	"3.8.34" : "insecure",
	"3.8.35" : "insecure",
	"3.8.36" : "insecure",
	"3.8.37" : "insecure",
	"3.8.38" : "insecure",
	"3.8.39" : "insecure",
	"3.8.40" : "insecure",
	"3.8.41" : "insecure",
	"3.9" : "insecure",
	"3.9.1" : "insecure",
	"3.9.2" : "insecure",
	"3.9.3" : "insecure",
	"3.9.4" : "insecure",
	"3.9.5" : "insecure",
	"3.9.6" : "insecure",
	"3.9.7" : "insecure",
	"3.9.8" : "insecure",
	"3.9.9" : "insecure",
	"3.9.10" : "insecure",
	"3.9.11" : "insecure",
	"3.9.12" : "insecure",
	"3.9.13" : "insecure",
	"3.9.14" : "insecure",
	"3.9.15" : "insecure",
	"3.9.16" : "insecure",
	"3.9.17" : "insecure",
	"3.9.18" : "insecure",
	"3.9.19" : "insecure",
	"3.9.20" : "insecure",
	"3.9.21" : "insecure",
	"3.9.22" : "insecure",
	"3.9.23" : "insecure",
	"3.9.24" : "insecure",
	"3.9.25" : "insecure",
	"3.9.26" : "insecure",
	"3.9.27" : "insecure",
	"3.9.28" : "insecure",
	"3.9.29" : "insecure",
	"3.9.30" : "insecure",
	"3.9.31" : "insecure",
	"3.9.32" : "insecure",
	"3.9.33" : "insecure",
	"3.9.34" : "insecure",
	"3.9.35" : "insecure",
	"3.9.36" : "insecure",
	"3.9.37" : "insecure",
	"3.9.39" : "insecure",
	"3.9.40" : "insecure",
	"4.0" : "insecure",
	"4.0.1" : "insecure",
	"4.0.2" : "insecure",
	"4.0.3" : "insecure",
	"4.0.4" : "insecure",
	"4.0.5" : "insecure",
	"4.0.6" : "insecure",
	"4.0.7" : "insecure",
	"4.0.8" : "insecure",
	"4.0.9" : "insecure",
	"4.0.10" : "insecure",
	"4.0.11" : "insecure",
	"4.0.12" : "insecure",
	"4.0.13" : "insecure",
	"4.0.14" : "insecure",
	"4.0.15" : "insecure",
	"4.0.16" : "insecure",
	"4.0.17" : "insecure",
	"4.0.18" : "insecure",
	"4.0.19" : "insecure",
	"4.0.20" : "insecure",
	"4.0.21" : "insecure",
	"4.0.22" : "insecure",
	"4.0.23" : "insecure",
	"4.0.24" : "insecure",
	"4.0.25" : "insecure",
	"4.0.26" : "insecure",
	"4.0.27" : "insecure",
	"4.0.28" : "insecure",
	"4.0.29" : "insecure",
	"4.0.30" : "insecure",
	"4.0.31" : "insecure",
	"4.0.32" : "insecure",
	"4.0.33" : "insecure",
	"4.0.34" : "insecure",
	"4.0.35" : "insecure",
	"4.0.36" : "insecure",
	"4.0.37" : "insecure",
	"4.0.38" : "insecure",
	"4.1" : "insecure",
	"4.1.1" : "insecure",
	"4.1.2" : "insecure",
	"4.1.3" : "insecure",
	"4.1.4" : "insecure",
	"4.1.5" : "insecure",
	"4.1.6" : "insecure",
	"4.1.7" : "insecure",
	"4.1.8" : "insecure",
	"4.1.9" : "insecure",
	"4.1.10" : "insecure",
	"4.1.11" : "insecure",
	"4.1.12" : "insecure",
	"4.1.13" : "insecure",
	"4.1.14" : "insecure",
	"4.1.15" : "insecure",
	"4.1.16" : "insecure",
	"4.1.17" : "insecure",
	"4.1.18" : "insecure",
	"4.1.19" : "insecure",
	"4.1.20" : "insecure",
	"4.1.21" : "insecure",
	"4.1.22" : "insecure",
	"4.1.23" : "insecure",
	"4.1.24" : "insecure",
	"4.1.25" : "insecure",
	"4.1.26" : "insecure",
	"4.1.27" : "insecure",
	"4.1.28" : "insecure",
	"4.1.29" : "insecure",
	"4.1.30" : "insecure",
	"4.1.31" : "insecure",
	"4.1.32" : "insecure",
	"4.1.33" : "insecure",
	"4.1.34" : "insecure",
	"4.1.35" : "insecure",
	"4.1.36" : "insecure",
	"4.1.37" : "insecure",
	"4.1.38" : "insecure",
	"4.1.39" : "insecure",
	"4.1.40" : "insecure",
	"4.2" : "insecure",
	"4.2.1" : "insecure",
	"4.2.2" : "insecure",
	"4.2.3" : "insecure",
	"4.2.4" : "insecure",
	"4.2.5" : "insecure",
	"4.2.6" : "insecure",
	"4.2.7" : "insecure",
	"4.2.8" : "insecure",
	"4.2.9" : "insecure",
	"4.2.10" : "insecure",
	"4.2.11" : "insecure",
	"4.2.12" : "insecure",
	"4.2.13" : "insecure",
	"4.2.14" : "insecure",
	"4.2.15" : "insecure",
	"4.2.16" : "insecure",
	"4.2.17" : "insecure",
	"4.2.18" : "insecure",
	"4.2.19" : "insecure",
	"4.2.20" : "insecure",
	"4.2.21" : "insecure",
	"4.2.22" : "insecure",
	"4.2.23" : "insecure",
	"4.2.24" : "insecure",
	"4.2.25" : "insecure",
	"4.2.26" : "insecure",
	"4.2.27" : "insecure",
	"4.2.28" : "insecure",
	"4.2.29" : "insecure",
	"4.2.30" : "insecure",
	"4.2.31" : "insecure",
	"4.2.32" : "insecure",
	"4.2.33" : "insecure",
	"4.2.34" : "insecure",
	"4.2.35" : "insecure",
	"4.2.36" : "insecure",
	"4.2.37" : "insecure",
	"4.3" : "insecure",
	"4.3.1" : "insecure",
	"4.3.2" : "insecure",
	"4.3.3" : "insecure",
	"4.3.4" : "insecure",
	"4.3.5" : "insecure",
	"4.3.6" : "insecure",
	"4.3.7" : "insecure",
	"4.3.8" : "insecure",
	"4.3.9" : "insecure",
	"4.3.10" : "insecure",
	"4.3.11" : "insecure",
	"4.3.12" : "insecure",
	"4.3.13" : "insecure",
	"4.3.14" : "insecure",
	"4.3.15" : "insecure",
	"4.3.16" : "insecure",
	"4.3.17" : "insecure",
	"4.3.18" : "insecure",
	"4.3.19" : "insecure",
	"4.3.20" : "insecure",
	"4.3.21" : "insecure",
	"4.3.22" : "insecure",
	"4.3.23" : "insecure",
	"4.3.24" : "insecure",
	"4.3.25" : "insecure",
	"4.3.26" : "insecure",
	"4.3.27" : "insecure",
	"4.3.28" : "insecure",
	"4.3.29" : "insecure",
	"4.3.30" : "insecure",
	"4.3.31" : "insecure",
	"4.3.32" : "insecure",
	"4.3.33" : "insecure",
	"4.4" : "insecure",
	"4.4.1" : "insecure",
	"4.4.2" : "insecure",
	"4.4.3" : "insecure",
	"4.4.4" : "insecure",
	"4.4.5" : "insecure",
	"4.4.6" : "insecure",
	"4.4.7" : "insecure",
	"4.4.8" : "insecure",
	"4.4.9" : "insecure",
	"4.4.10" : "insecure",
	"4.4.11" : "insecure",
	"4.4.12" : "insecure",
	"4.4.13" : "insecure",
	"4.4.14" : "insecure",
	"4.4.15" : "insecure",
	"4.4.16" : "insecure",
	"4.4.17" : "insecure",
	"4.4.18" : "insecure",
	"4.4.19" : "insecure",
	"4.4.20" : "insecure",
	"4.4.21" : "insecure",
	"4.4.22" : "insecure",
	"4.4.23" : "insecure",
	"4.4.24" : "insecure",
	"4.4.25" : "insecure",
	"4.4.26" : "insecure",
	"4.4.27" : "insecure",
	"4.4.28" : "insecure",
	"4.4.29" : "insecure",
	"4.4.30" : "insecure",
	"4.4.31" : "insecure",
	"4.4.32" : "insecure",
	"4.5" : "insecure",
	"4.5.1" : "insecure",
	"4.5.2" : "insecure",
	"4.5.3" : "insecure",
	"4.5.4" : "insecure",
	"4.5.5" : "insecure",
	"4.5.6" : "insecure",
	"4.5.7" : "insecure",
	"4.5.8" : "insecure",
	"4.5.9" : "insecure",
	"4.5.10" : "insecure",
	"4.5.11" : "insecure",
	"4.5.12" : "insecure",
	"4.5.13" : "insecure",
	"4.5.14" : "insecure",
	"4.5.15" : "insecure",
	"4.5.16" : "insecure",
	"4.5.17" : "insecure",
	"4.5.18" : "insecure",
	"4.5.19" : "insecure",
	"4.5.20" : "insecure",
	"4.5.21" : "insecure",
	"4.5.22" : "insecure",
	"4.5.23" : "insecure",
	"4.5.24" : "insecure",
	"4.5.25" : "insecure",
	"4.5.26" : "insecure",
	"4.5.27" : "insecure",
	"4.5.28" : "insecure",
	"4.5.29" : "insecure",
	"4.5.30" : "insecure",
	"4.5.31" : "insecure",
	"4.6" : "insecure",
	"4.6.1" : "insecure",
	"4.6.2" : "insecure",
	"4.6.3" : "insecure",
	"4.6.4" : "insecure",
	"4.6.5" : "insecure",
	"4.6.6" : "insecure",
	"4.6.7" : "insecure",
	"4.6.8" : "insecure",
	"4.6.9" : "insecure",
	"4.6.10" : "insecure",
	"4.6.11" : "insecure",
	"4.6.12" : "insecure",
	"4.6.13" : "insecure",
	"4.6.14" : "insecure",
	"4.6.15" : "insecure",
	"4.6.16" : "insecure",
	"4.6.17" : "insecure",
	"4.6.18" : "insecure",
	"4.6.19" : "insecure",
	"4.6.20" : "insecure",
	"4.6.21" : "insecure",
	"4.6.22" : "insecure",
	"4.6.23" : "insecure",
	"4.6.24" : "insecure",
	"4.6.25" : "insecure",
	"4.6.26" : "insecure",
	"4.6.27" : "insecure",
	"4.6.28" : "insecure",
	"4.7" : "insecure",
	"4.7.1" : "insecure",
	"4.7.2" : "insecure",
	"4.7.3" : "insecure",
	"4.7.4" : "insecure",
	"4.7.5" : "insecure",
	"4.7.6" : "insecure",
	"4.7.7" : "insecure",
	"4.7.8" : "insecure",
	"4.7.9" : "insecure",
	"4.7.10" : "insecure",
	"4.7.11" : "insecure",
	"4.7.12" : "insecure",
	"4.7.13" : "insecure",
	"4.7.14" : "insecure",
	"4.7.15" : "insecure",
	"4.7.16" : "insecure",
	"4.7.17" : "insecure",
	"4.7.18" : "insecure",
	"4.7.19" : "insecure",
	"4.7.20" : "insecure",
	"4.7.21" : "insecure",
	"4.7.22" : "insecure",
	"4.7.23" : "insecure",
	"4.7.24" : "insecure",
	"4.7.25" : "insecure",
	"4.7.26" : "insecure",
	"4.7.27" : "insecure",
	"4.7.28" : "insecure",
	"4.8" : "insecure",
	"4.8.1" : "insecure",
	"4.8.2" : "insecure",
	"4.8.3" : "insecure",
	"4.8.4" : "insecure",
	"4.8.5" : "insecure",
	"4.8.6" : "insecure",
	"4.8.7" : "insecure",
	"4.8.8" : "insecure",
	"4.8.9" : "insecure",
	"4.8.10" : "insecure",
	"4.8.11" : "insecure",
	"4.8.12" : "insecure",
	"4.8.13" : "insecure",
	"4.8.14" : "insecure",
	"4.8.15" : "insecure",
	"4.8.16" : "insecure",
	"4.8.17" : "insecure",
	"4.8.18" : "insecure",
	"4.8.19" : "insecure",
	"4.8.20" : "insecure",
	"4.8.21" : "insecure",
	"4.8.22" : "insecure",
	"4.8.23" : "insecure",
	"4.8.24" : "insecure",
	"4.9" : "insecure",
	"4.9.1" : "insecure",
	"4.9.2" : "insecure",
	"4.9.3" : "insecure",
	"4.9.4" : "insecure",
	"4.9.5" : "insecure",
	"4.9.6" : "insecure",
	"4.9.7" : "insecure",
	"4.9.8" : "insecure",
	"4.9.9" : "insecure",
	"4.9.10" : "insecure",
	"4.9.11" : "insecure",
	"4.9.12" : "insecure",
	"4.9.13" : "insecure",
	"4.9.14" : "insecure",
	"4.9.15" : "insecure",
	"4.9.16" : "insecure",
	"4.9.17" : "insecure",
	"4.9.18" : "insecure",
	"4.9.19" : "insecure",
	"4.9.20" : "insecure",
	"4.9.21" : "insecure",
	"4.9.22" : "insecure",
	"4.9.23" : "insecure",
	"4.9.24" : "insecure",
	"4.9.25" : "insecure",
	"5.0" : "insecure",
	"5.0.1" : "insecure",
	"5.0.2" : "insecure",
	"5.0.3" : "insecure",
	"5.0.4" : "insecure",
	"5.0.6" : "insecure",
	"5.0.7" : "insecure",
	"5.0.8" : "insecure",
	"5.0.9" : "insecure",
	"5.0.10" : "insecure",
	"5.0.11" : "insecure",
	"5.0.12" : "insecure",
	"5.0.13" : "insecure",
	"5.0.14" : "insecure",
	"5.0.15" : "insecure",
	"5.0.16" : "insecure",
	"5.0.17" : "insecure",
	"5.0.18" : "insecure",
	"5.0.19" : "insecure",
	"5.0.20" : "insecure",
	"5.0.21" : "insecure",
	"5.1" : "insecure",
	"5.1.1" : "insecure",
	"5.1.2" : "insecure",
	"5.1.3" : "insecure",
	"5.1.4" : "insecure",
	"5.1.5" : "insecure",
	"5.1.6" : "insecure",
	"5.1.7" : "insecure",
	"5.1.8" : "insecure",
	"5.1.9" : "insecure",
	"5.1.10" : "insecure",
	"5.1.11" : "insecure",
	"5.1.12" : "insecure",
	"5.1.13" : "insecure",
	"5.1.14" : "insecure",
	"5.1.15" : "insecure",
	"5.1.16" : "insecure",
	"5.1.17" : "insecure",
	"5.1.18" : "insecure",
	"5.2" : "insecure",
	"5.2.1" : "insecure",
	"5.2.2" : "insecure",
	"5.2.3" : "insecure",
	"5.2.4" : "insecure",
	"5.2.5" : "insecure",
	"5.2.6" : "insecure",
	"5.2.7" : "insecure",
	"5.2.8" : "insecure",
	"5.2.9" : "insecure",
	"5.2.10" : "insecure",
	"5.2.11" : "insecure",
	"5.2.12" : "insecure",
	"5.2.13" : "insecure",
	"5.2.14" : "insecure",
	"5.2.15" : "insecure",
	"5.2.16" : "insecure",
	"5.2.17" : "insecure",
	"5.2.18" : "insecure",
	"5.2.19" : "insecure",
	"5.2.20" : "insecure",
	"5.3" : "insecure",
	"5.3.1" : "insecure",
	"5.3.2" : "insecure",
	"5.3.3" : "insecure",
	"5.3.4" : "insecure",
	"5.3.5" : "insecure",
	"5.3.6" : "insecure",
	"5.3.7" : "insecure",
	"5.3.8" : "insecure",
	"5.3.9" : "insecure",
	"5.3.10" : "insecure",
	"5.3.11" : "insecure",
	"5.3.12" : "insecure",
	"5.3.13" : "insecure",
	"5.3.14" : "insecure",
	"5.3.15" : "insecure",
	"5.3.16" : "insecure",
	"5.3.17" : "insecure",
	"5.4" : "insecure",
	"5.4.1" : "insecure",
	"5.4.2" : "insecure",
	"5.4.3" : "insecure",
	"5.4.4" : "insecure",
	"5.4.5" : "insecure",
	"5.4.6" : "insecure",
	"5.4.7" : "insecure",
	"5.4.8" : "insecure",
	"5.4.9" : "insecure",
	"5.4.10" : "insecure",
	"5.4.11" : "insecure",
	"5.4.12" : "insecure",
	"5.4.13" : "insecure",
	"5.4.14" : "insecure",
	"5.4.15" : "insecure",
	"5.5" : "insecure",
	"5.5.1" : "insecure",
	"5.5.2" : "insecure",
	"5.5.3" : "insecure",
	"5.5.4" : "insecure",
	"5.5.5" : "insecure",
	"5.5.6" : "insecure",
	"5.5.7" : "insecure",
	"5.5.8" : "insecure",
	"5.5.9" : "insecure",
	"5.5.10" : "insecure",
	"5.5.11" : "insecure",
	"5.5.12" : "insecure",
	"5.5.13" : "insecure",
	"5.5.14" : "insecure",
	"5.6" : "insecure",
	"5.6.1" : "insecure",
	"5.6.2" : "insecure",
	"5.6.3" : "insecure",
	"5.6.4" : "insecure",
	"5.6.5" : "insecure",
	"5.6.6" : "insecure",
	"5.6.7" : "insecure",
	"5.6.8" : "insecure",
	"5.6.9" : "insecure",
	"5.6.10" : "insecure",
	"5.6.11" : "insecure",
	"5.6.12" : "insecure",
	"5.6.13" : "insecure",
	"5.7" : "insecure",
	"5.7.1" : "insecure",
	"5.7.2" : "insecure",
	"5.7.3" : "insecure",
	"5.7.4" : "insecure",
	"5.7.5" : "insecure",
	"5.7.6" : "insecure",
	"5.7.7" : "insecure",
	"5.7.8" : "insecure",
	"5.7.9" : "insecure",
	"5.7.10" : "insecure",
	"5.7.11" : "insecure",
	"5.8" : "insecure",
	"5.8.1" : "insecure",
	"5.8.2" : "insecure",
	"5.8.3" : "insecure",
	"5.8.4" : "insecure",
	"5.8.5" : "insecure",
	"5.8.6" : "insecure",
	"5.8.7" : "insecure",
	"5.8.8" : "insecure",
	"5.8.9" : "insecure",
	"5.9" : "insecure",
	"5.9.1" : "insecure",
	"5.9.2" : "insecure",
	"5.9.3" : "insecure",
	"5.9.4" : "insecure",
	"5.9.5" : "insecure",
	"5.9.6" : "insecure",
	"5.9.7" : "insecure",
	"5.9.8" : "insecure",
	"5.9.9" : "insecure",
	"6.0" : "insecure",
	"6.0.1" : "insecure",
	"6.0.2" : "insecure",
	"6.0.3" : "insecure",
	"6.0.4" : "insecure",
	"6.0.5" : "insecure",
	"6.0.6" : "insecure",
	"6.0.7" : "insecure",
	"6.0.8" : "insecure",
	"6.1" : "insecure",
	"6.1.1" : "insecure",
	"6.1.2" : "insecure",
	"6.1.3" : "insecure",
	"6.1.4" : "insecure",
	"6.1.5" : "insecure",
	"6.1.6" : "insecure",
	"6.2" : "insecure",
	"6.2.1" : "insecure",
	"6.2.2" : "insecure",
	"6.2.3" : "insecure",
	"6.2.4" : "insecure",
	"6.2.5" : "insecure",
	"6.3" : "insecure",
	"6.3.1" : "insecure",
	"6.3.2" : "insecure",
	"6.3.3" : "insecure",
	"6.3.4" : "insecure",
	"6.4" : "insecure",
	"6.4.1" : "insecure",
	"6.4.2" : "insecure",
	"6.4.3" : "insecure",
	"6.4.4" : "insecure",
	"6.5" : "insecure",
	"6.5.2" : "insecure",
	"6.5.3" : "insecure",
	"6.5.4" : "insecure",
	"6.6" : "insecure",
	"4.1.41" : "outdated",
	"4.2.38" : "outdated",
	"4.3.34" : "outdated",
	"4.4.33" : "outdated",
	"4.5.32" : "outdated",
	"4.6.29" : "outdated",
	"4.7.29" : "outdated",
	"4.8.25" : "outdated",
	"4.9.26" : "outdated",
	"5.0.22" : "outdated",
	"5.1.19" : "outdated",
	"5.2.21" : "outdated",
	"5.3.18" : "outdated",
	"5.4.16" : "outdated",
	"5.5.15" : "outdated",
	"5.6.14" : "outdated",
	"5.7.12" : "outdated",
	"5.8.10" : "outdated",
	"5.9.10" : "outdated",
	"6.0.9" : "outdated",
	"6.1.7" : "outdated",
	"6.2.6" : "outdated",
	"6.3.5" : "outdated",
	"6.4.5" : "outdated",
	"6.5.5" : "outdated",
	"6.6.1" : "outdated",
	"6.6.2" : "latest"
}

JSON;

	$url = 'https://api.wordpress.org/core/stable-check/1.0/';
	$response = wp_remote_get( $url );

	$this->assertEquals( 200, wp_remote_retrieve_response_code( $response ) );

	$body = wp_remote_retrieve_body( $response );
	$this->assertNotEmpty( $body );

	// TODO: figure out a way to adapt this to work when the API is updated for newer versions.
	// Maybe just check for the presence of a few known values?
	$this->assertEquals( trim($expected), trim($body) );

	}
}

