<?php

use PHPUnit\Framework\TestCase;

/**
 * @group plugins
 */
class TestPluginsUpdateCheck extends TestCase {

	public static function update_check_provider() {
		return [
			[ 'https://api.wordpress.org/plugins/update-check/1.0/',
			  [ 'plugins' => 'O:8:"stdClass":2:{s:7:"plugins";a:1:{s:57:"wordpress-auto-update-test/wordpress-auto-update-test.php";a:5:{s:4:"Name";s:25:"Example Autoupdate plugin";s:5:"Title";s:25:"Example Autoupdate plugin";s:11:"Description";s:3:"Bar";s:6:"Author";s:3:"Baz";s:7:"Version";s:3:"1.0";}}s:6:"active";a:1:{i:0;s:57:"wordpress-auto-update-test/wordpress-auto-update-test.php";}}' ],
			  'text/plain; charset=utf-8',
			  'a:0:{}',
			],
			[ 'https://api.wordpress.org/plugins/update-check/1.1/',
			  [ 'plugins' =>  '{
    "plugins": {
        "wordpress-auto-update-test\/wordpress-auto-update-test.php": {
            "Name": "Example Autoupdate plugin",
            "Title": "Example Autoupdate plugin",
            "Description": "Bar",
            "Author": "Baz",
            "Version": "1.0"
        }
    },
    "active": [
        "wordpress-auto-update-test\/wordpress-auto-update-test.php"
    ]
}'],
			  'application/json; charset=utf-8',
			  '{"plugins":[],"translations":[]}'
			],
			[ 'https://api.wordpress.org/plugins/update-check/1.2/',
			  [ 'plugins' => '{
    "plugins": {
        "wordpress-auto-update-test\/wordpress-auto-update-test.php": {
            "Name": "Example Autoupdate plugin",
            "Title": "Example Autoupdate plugin",
            "Description": "Bar",
            "Author": "Baz",
            "Version": "1.0"
        }
    },
    "active": [
        "wordpress-auto-update-test\/wordpress-auto-update-test.php"
    ]
}' ],
			  'application/json; charset=utf-8',
			  '{"plugins":[],"translations":[],"no_update":[]}'
			],
		];
	}

	/**
	 * @dataProvider update_check_provider
	 */
	public function test_update_check( $url, $body, $expected_content_type, $expected_body ) {
		$args = [
			'body' => $body,
		];

		$response = wp_remote_post( $url, $args );

		$this->assertEquals( 200, wp_remote_retrieve_response_code( $response ) );
		$this->assertNotEquals( 'error', wp_remote_retrieve_body( $response ) );

		$this->assertEquals( $expected_content_type, wp_remote_retrieve_header( $response, 'content-type' ) );
		$this->assertEquals( $expected_body, wp_remote_retrieve_body( $response ) );
	}

}