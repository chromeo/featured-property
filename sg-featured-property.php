<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/chromeo
 * @since             1.0.0
 * @package           Sg_Featured_Property
 *
 * @wordpress-plugin
 * Plugin Name:       Featured Properties
 * Plugin URI:        https://github.com/chromeo/featured-property
 * Description:       Create, edit, and display all of the featured properties (a Strouope Group custom post type)
 * Version:           1.0.9
 * Author:            Gary Darling
 * Author URI:        https://github.com/chromeo
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sg-featured-property
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define('SGFP_PLUGIN_DIR', dirname(__FILE__) . '/');
define('SGFP_PLUGIN_VERSION', '1.0.9');
define('SGFP_PLUGIN_NAME', 'sg-featured-property');
define('SGFP_CPT_SLUG', 'featured');
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-sg-featured-property-activator.php
 */
function activate_sg_featured_property() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sg-featured-property-activator.php';
	Sg_Featured_Property_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-sg-featured-property-deactivator.php
 */
function deactivate_sg_featured_property() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sg-featured-property-deactivator.php';
	Sg_Featured_Property_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_sg_featured_property' );
register_deactivation_hook( __FILE__, 'deactivate_sg_featured_property' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-sg-featured-property.php';

/**
 * Identify the template in use for easier debug
 *
 * @since 1.0.0
 *
 * @param string  $location   Some text to show where you are in the template (ie: top, bottom, loop-start, etc)
 * @param constant  $file     Server variable showing file name and/or location
 *
 * @usage sg_template_identifier('begin',__FILE__);
 * note: param defaults do not work here, files need to send their name and location to the function
 */
if ( ! function_exists('sg_template_identifier') ) {
  function sg_template_identifier( $location, $file ) {
    if ( current_user_can( 'manage_options' ) ) {
      ?> <!-- <?php echo $location . " filename:[" . basename( $file ) . "] theme:[". esc_html( get_stylesheet() ) ."] post-type:[" . get_post_type() . "] " ; ?> --> <?php
    }
    else {
      return;
    }
  }
}


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_sg_featured_property() {

	$plugin = new Sg_Featured_Property();
	$plugin->run();

}
run_sg_featured_property();
