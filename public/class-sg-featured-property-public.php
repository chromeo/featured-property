<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/chromeo
 * @since      1.0.0
 *
 * @package    Sg_Featured_Property
 * @subpackage Sg_Featured_Property/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Sg_Featured_Property
 * @subpackage Sg_Featured_Property/public
 * @author     Gary Darling <garydarling@gmail.com>
 */
class Sg_Featured_Property_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

  /**
   * The version of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      string    $version    The current version of this plugin.
   */
  private $cpt_slug;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $cpt_slug ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
    $this->cpt_slug = $cpt_slug;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Sg_Featured_Property_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sg_Featured_Property_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/sg-featured-property-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

    if ( is_singular( SGFP_CPT_SLUG ) ) {
      wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/sg-featured-property-public.js', array( 'jquery' ), $this->version, false );
      wp_enqueue_script( 'bootstrapjs', 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js', array( 'jquery' ), $this->version, false );
      if ( 'localhost' == $_SERVER['SERVER_NAME'] ) {
        wp_enqueue_script( 'g-maps', 'https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyDBBaUZFhrU-9cYYDQJOboRyXqTYloyL9w', '', $this->version, true); // localhost version
      } else {
        wp_enqueue_script( 'g-maps', 'https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyAB9OUEUtoNa6fE1_ymIhxn5FXdZiDh38Q', '', $this->version, true); // stroupe version
      }
    }

	}


  /**
   * Register the ajax functionality for the front end.
   *
   * @since    1.0.0
   */
  public function ajax_setup() {

    wp_localize_script( $this->plugin_name . '-public', 'sgfp', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

  }


  /**
   * Returns the slug of the current custom post
   *
   * @since 1.0
   */

  public function the_slug( $echo = false ){

    $slug = basename( get_permalink() );
    do_action( 'before_slug', $slug );
    $slug = apply_filters( 'slug_filter', $slug );
    if ( $echo ) echo $slug;
    do_action( 'after_slug', $slug );
    return $slug;

  }


  /**
   * Returns template file
   *
   * @since 1.0
   */

  public function sgfp_template_chooser( $template ) {

      // Post ID
      $post_id = get_the_ID();

      // For all other CPT
      if ( get_post_type( $post_id ) != $this->cpt_slug ) {
          return $template;
      }

      // Else use custom template
      if ( is_single() ) {
          return $this->sgfp_get_template_hierarchy( 'single-' . $this->cpt_slug  );
      }
      if ( is_archive() ) {
          return $this->sgfp_get_template_hierarchy( 'all-' . $this->cpt_slug  );
      }

  }


  /**
   * Get the custom template if is set
   *
   * @since 1.0
   */

  public function sgfp_get_template_hierarchy( $template ) {

    $server = $_SERVER['SERVER_NAME'];

    if ( 'localhost' == $server ) {
      $template = $template . '-2017';
    }

    // Get the template slug
    $template_slug = rtrim( $template, '.php' );
    $template = $template_slug . '.php';


    // Check if a custom template exists in the theme folder, if not, load the plugin template file
    if ( $theme_file = locate_template( array( 'plugin_template/' . $template ) ) ) {
        $file = $theme_file;
    }
    else {
        $file = SGFP_PLUGIN_DIR . '/public/templates/' . $template;
    }

    return $file;
  }

  /*
   * Modify the post links with new classes
   *
   * @since 1.0
   * @return string additional classes
   */
  public function sgfp_posts_link_attributes() {
    return 'class="mb-10"';
  }

  public function sgfp_next_posts_link_attributes() {
          return 'class="pull-right"';
  }


  /**
   * a quick, easy way to check if a var isset before outputting it in a template
   * avoids annoying 'Undefined index' notice in debug log
   *
   *
   * @param string, $var, any variable that echoes to the template, Required
   * @param string, $default, leave alone - false is the correct value, Optional
   * @return string Return if isset it returns the var value, else it returns false
   */
  public function issetor(&$var, $default = false) {
      return isset($var) ? $var : $default;
  }

  /**
   * delete looping vars so we don't carry artifacts to the next property
   *
   * @since 1.0
   * @return void
   */
  public function destroy_featured_vars() {
    // $vars = array($status,$cover_image,$slider_id,$sub_title,$footer_text,$building_id,$street_address,$list_price,$year_built,$sq_footage,$gallery_image,$representing,$mls_num,$visual_tour,$marketing,$directions,$sell_price,$prop_type,$bedrooms,$bathrooms,$parking,$ho_dues,$annual_taxes,$tax_year,$price_label,$building_name,$gd_image,$neighborhood,$stat_name,$stat_slug,$hood_name,$hood_slug);
    $vars = array();
    foreach ($vars as $var) {
      unset($var);
    }
  }

}
