<?php
/**
 * Template interface.
 *
 * Defines the interface that template classes must use.
 *
 * @package   Backdrop
 * @author    Benjamin Lu <benlumia007@gmail.com>
 * @copyright 2019-2023. Benjamin Lu
 * @license   https://www.gnu.org/licenses/gpl-2.0.html
 * @link      https://github.com/benlumia007/backdrop-template-manager
 */

/**
 * Define namespace
 * 
 * @since  1.0.0
 * @access public
 */
namespace Backdrop\Template\Manager\Contracts;
use Backdrop\Contracts\Bootable;

/**
 * Template interface.
 * 
 * @since  1.0.0
 * @access public
 */
interface Template {
    	/**
	 * Returns the filename relative to the templates location.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function filename();

	/**
	 * Returns the internationalized text label for the template.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function label();

	/**
	 * Conditional function to check what type of template this is.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return bool
	 */
	public function isType( $type );

	/**
	 * Conditional function to check if the template has a specific subtype.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return bool
	 */
	public function hasSubtype( $subtype );

	/**
	 * Conditional function to check if the template is for a post type.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return bool
	 */
	public function forPostType( $type );
}