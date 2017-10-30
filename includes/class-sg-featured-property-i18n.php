<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/chromeo
 * @since      1.0.0
 *
 * @package    Sg_Featured_Property
 * @subpackage Sg_Featured_Property/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Sg_Featured_Property
 * @subpackage Sg_Featured_Property/includes
 * @author     Gary Darling <garydarling@gmail.com>
 */
class Sg_Featured_Property_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'sgfp',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
