# Backdrop Template Manager

Backdrop Template Manager registers custom templates for any object type. It currently adds them to the template drop-down of every post type (or only the post types you pick), and does not add any UI of its own.

The major difference from the typical WordPress page template system is that the template file doesn't have to exist for registration, and templates default to every post type instead of only pages.

## Requirements
* PHP 7.4 or later
* [backdrop-dev/framework](https://github.com/backdrop-dev/framework) ^2.0
* [backdrop-dev/tools](https://github.com/backdrop-dev/tools) ^1.0

## Installation
```
composer require backdrop-dev/template-manager
```

Register the provider when you boot your application:

```php
$app->provider( \Backdrop\Template\Manager\Provider::class );
```

## Usage
Register your templates on the `backdrop/templates/register` action. It runs on `init` and passes the templates collection.

```php
add_action( 'backdrop/templates/register', function ( $templates ) {

	// For every post type.
	$templates->add( 'custom-templates/wide.php', [ 'label' => __( 'Wide', 'textdomain' ) ] );

	// Only for pages (`subtype` and `post_types` are the same thing).
	$templates->add( 'custom-templates/landing.php', [
		'label'      => __( 'Landing', 'textdomain' ),
		'post_types' => [ 'page' ]
	] );
} );
```

The first argument is the template filename relative to your theme. Labels are escaped when they are listed. The collection is also bound in the container as `Backdrop\Template\Manager\Templates`.

Loading the chosen template on the front end is up to your theme, for example with the [template hierarchy](https://github.com/backdrop-dev/template-hierarchy) package, which looks at the saved `_wp_page_template` value.

## Tests
```
php tests/run.php
```

## Copyright and Licenses
This project is licensed under the GNU GPL, version 2 or later.

2019–2026 © Benjamin Lu
