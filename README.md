# wporg-api-tests

Experimental end-to-end tests for api.wordpress.org

## Why?

This is a WIP attempt at building e2e regression test coverage for the WordPress.org APIs (which are used for version checks, auto-updates, plugin and theme search, and so on). It's a quick first draft meant to explore various types of tests, and to use as a better-than-nothing baseline test.

Scripts are configured to run it easily with `wp-now`; but it's a simple phpunit test suite as defined in `phpunit.xml.dist`.

## Usage

```
$ composer install
$ npm install
$ npm run test
```

