<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/chromeo
 * @since      1.0.0
 * @package    Sg_Featured_Property
 * @subpackage Sg_Featured_Property/includes
 * @author     Gary Darling <garydarling@gmail.com>
 */
class Sg_Featured_Property {

  // const SGFP_PLUGIN_VERSION = '1.0.0';

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Sg_Featured_Property_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $cpt_slug;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		$this->version = SGFP_PLUGIN_VERSION;
		$this->plugin_name = SGFP_PLUGIN_NAME;
		$this->cpt_slug = SGFP_CPT_SLUG;
		$this->load_dependencies();
		$this->set_locale();
		$this->define_custom_post_type();
		$this->define_featured_meta();
		// $this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_required_plugins();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Sg_Featured_Property_Loader. Orchestrates the hooks of the plugin.
	 * - Sg_Featured_Property_i18n. Defines internationalization functionality.
	 * - Sg_Featured_Property_Admin. Defines all hooks for the admin area.
	 * - Sg_Featured_Property_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sg-featured-property-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sg-featured-property-i18n.php';

		/**
		 * The class responsible for defining all actions that create our custom post type.
		 */

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sg-featured-property-cpt.php';

		/**
		 * The class responsible for defining all actions that create our custom metaboxes.
		 */

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sg-featured-property-metabox.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-sg-featured-property-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-sg-featured-property-public.php';
    // require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/single-sg-featured-property.php';

		/**
		 * The class responsible for defining all the requires & recommended plugins
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-tgm-plugin-activation.php';

		$this->loader = new Sg_Featured_Property_Loader();

	}

	/**
	 * Define the required/recommended plugins this plugin needs to operate
   *
   * Uses the Tgm_Plugin_Activation class
	 *
   * @since    1.0.0
	 * @return void
	 * @access private
	 **/
	private function define_required_plugins() {

		// $plugin_tgmpa = new TGM_Plugin_Activation();
		$this->loader->add_action( 'tgmpa_register', $this, 'register_required_plugins' );

	}

	/**
	* Define the locale for this plugin for internationalization.
	*
	* Uses the Sg_Featured_Property_i18n class in order to set the domain and to register the hook
	* with WordPress.
	*
	* @since    1.0.0
	* @access   private
	*/
	private function set_locale() {

		$plugin_i18n = new Sg_Featured_Property_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Define the Featured Property custom post type.
	 *
	 * Uses the Sg_Featured_Property_Cpt class to create the post editor in Worpress
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_custom_post_type() {

		$plugin_cpt = new Sg_Featured_Property_Cpt( $this->get_cpt_slug() );

	    $this->loader->add_action( 'init', $plugin_cpt, 'fp_custom_post_type', 0 );
	    $this->loader->add_action( 'init', $plugin_cpt, 'fp_custom_taxonomy', 0 );
	    $this->loader->add_action( 'after_switch_theme', $plugin_cpt, 'fp_flush_rewrite' );

	}

	/**
	 * Define the Featured Property custom post type.
	 *
	 * Uses the Sg_Featured_Property_Cpt class to create the post editor in Worpress
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_featured_meta() {

		$plugin_meta = new Sg_Featured_Property_Metabox( $this->get_cpt_slug() );

	    $this->loader->add_filter( 'rwmb_meta_boxes', $plugin_meta, 'props_register_meta_boxes', 0 );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Sg_Featured_Property_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Sg_Featured_Property_Public( $this->get_plugin_name(), $this->get_version(), $this->get_cpt_slug() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
    $this->loader->add_action( 'wp_print_scripts', $plugin_public, 'ajax_setup' );
    // tempting to use the action 'save_posts' here, but it gives us an undefined index notice. Use 'publish_{cpt}' instead
    // https://wordpress.stackexchange.com/questions/19538/why-does-save-post-action-fire-when-creating-a-new-post
    $this->loader->add_action( 'publish_' . SGFP_CPT_SLUG, $this, 'featured_set_post_thumb');
    $this->loader->add_filter( 'previous_posts_link_attributes', $plugin_public, 'sgfp_posts_link_attributes' );
    $this->loader->add_filter( 'next_posts_link_attributes', $plugin_public, 'sgfp_posts_link_attributes' );
    $this->loader->add_filter( 'next_posts_link_attributes', $plugin_public, 'sgfp_next_posts_link_attributes' );
    $this->loader->add_filter( 'template_include', $plugin_public, 'sgfp_template_chooser');

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Sg_Featured_Property_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_cpt_slug() {
		return $this->cpt_slug;
	}

  /**
   * featured_set_post_thumb
   *
   * Set the Featured Image == to the Cover Image
   *
   * @category  custom post type
   * @author    Gary Darling <garydarling@gmail.com>
   * @copyright 2015 Gary Darling
   */
  public function featured_set_post_thumb() {
    global $post, $post_type;

    $featured = $this->get_cpt_slug();

    if ( $post_type == $featured ) {

      $image_id = get_post_meta( $post->ID, 'props_cover_image', true );

      require_once(ABSPATH . 'wp-admin/includes/file.php');
      require_once(ABSPATH . 'wp-admin/includes/media.php');
      set_time_limit(300);

      if ( ! empty($image_id) ) {
        set_post_thumbnail( $post->ID, $image_id );
      }
      return;
    }
  }

	/**
	 * Register the required plugins for this theme.
	 *
	 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
	 */
	public function register_required_plugins() {
		/*
		 * Array of plugin arrays. Required keys are name and slug.
		 * If the source is NOT from the .org repo, then source is also required.
		 */
		$plugins = array(

			// This is an example of how to include a plugin from the WordPress Plugin Repository.
			array(
				'name'      => 'Meta Box',
				'slug'      => 'meta-box',
				'required'  => true,
			),
			// This is an example of how to include a plugin from an arbitrary external source in your theme.
			array(
				'name'         => 'Meta Box Columns', // The plugin name.
				'slug'         => 'meta-box-columns', // The plugin slug (typically the folder name).
				'source'       => 'https://metabox.io/plugins/meta-box-columns/', // The plugin source.
				'required'     => false, // If false, the plugin is only 'recommended' instead of required.
				'external_url' => 'https://metabox.io/plugins/meta-box-columns/', // If set, overrides default API URL and points to an external URL.
			),
			array(
				'name'         => 'Meta Box Group', // The plugin name.
				'slug'         => 'meta-box-group', // The plugin slug (typically the folder name).
				'source'       => 'https://metabox.io/plugins/meta-box-group/', // The plugin source.
				'required'     => false, // If false, the plugin is only 'recommended' instead of required.
				'external_url' => 'https://metabox.io/plugins/meta-box-group/', // If set, overrides default API URL and points to an external URL.
			),
			array(
				'name'         => 'Meta Box Tabs', // The plugin name.
				'slug'         => 'meta-box-tabs', // The plugin slug (typically the folder name).
				'source'       => 'https://metabox.io/plugins/meta-box-tabs/', // The plugin source.
				'required'     => false, // If false, the plugin is only 'recommended' instead of required.
				'external_url' => 'https://metabox.io/plugins/meta-box-tabs/', // If set, overrides default API URL and points to an external URL.
			),
			array(
				'name'         => 'Building Profiles', // The plugin name.
				'slug'         => 'sg-building-profiles', // The plugin slug (typically the folder name).
				'source'       => 'https://github.com/chromeo/Stroupe/sg-building-profiles.zip', // The plugin source.
				'required'     => false, // If false, the plugin is only 'recommended' instead of required.
				'external_url' => 'https://github.com/chromeo/Stroupe/', // If set, overrides default API URL and points to an external URL.
			),
		);

		/*
		 * Array of configuration settings. Amend each line as needed.
		 *
		 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
		 * strings available, please help us make TGMPA even better by giving us access to these translations or by
		 * sending in a pull-request with .po file(s) with the translations.
		 *
		 * Only uncomment the strings in the config array if you want to customize the strings.
		 */
		$config = array(
			'id'           => 'sgfp',                 // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                      // Default absolute path to bundled plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'parent_slug'  => 'plugins.php',            // Parent menu slug.
			'capability'   => 'manage_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.
		);

		tgmpa( $plugins, $config );
	}

}
