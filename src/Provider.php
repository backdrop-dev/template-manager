<?php
/**
 * Object templates service provider.
 *
 * This is the service provider for the object templates system, which binds an
 * empty collection to the container that can later be used to register templates.
 *
 * @package   Backdrop Core
 * @copyright Copyright (C) 2019-2021. Benjamin Lu
 * @author    Benjamin Lu ( https://getbenonit.com )
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Backdrop\Template\Manager;
use Backdrop\Template\Manager\Component;
use Backdrop\Core\ServiceProvider;

/**
 * Object templates provider class.
 *
 * @since  1.0.0
 * @access public
 */
class Provider extends ServiceProvider {

	/**
	 * Registers the templates collection and manager.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function register() {

		$this->app->singleton( Component::class );

		$this->app->alias( Component::class, 'template/manager' );
	}

	/**
	 * Boots the manager by firing its hooks in the `boot()` method.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function boot() {

		$this->app->resolve( 'template/manager' )->boot();
	}
}