<?php

/**
 * The file that defines the featured property custom post type
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/chromeo
 * @since      1.0.0
 *
 * @package    Sg_Featured_Property
 * @subpackage Sg_Featured_Property/includes
 */

/**
 * Sg_Featured_Property_Cpt class
 *
 * @package default
 * @subpackage Sg_Featured_Property/includes
 * @author     Gary Darling <garydarling@gmail.com>
 **/
class Sg_Featured_Property_Cpt {

  /**
   * The slug of our Featured Property custom post type.
   *
   * @since    1.0.0
   * @access   private
   * @var      string    $version    The current version of the plugin.
   */
  private $cpt_slug;

  /**
   * Initialize the class and set its properties.
   *
   * @since    1.0.0
   * @param      string    $cpt_slug       The name of this plugin.
   */
  public function __construct( $cpt_slug ) {

      $this->cpt_slug = $cpt_slug;

  }

  /**
   * Update the options table rewrite_rules setting
   *
   * @since 1.0
   * @return void
   */
  public function fp_flush_rewrite() {

    if ( get_option('plugin_settings_have_changed') == true ) {
        flush_rewrite_rules();
        update_option('plugin_settings_have_changed', false);
    }

  }

  /**
   * Define the Featured Property CPT
   *
   * @since 1.0
   * @return void
   */
  public function fp_custom_post_type() {

    $prop_labels = array(
      'name'                => _x( 'Featured Properties', 'Post Type General Name', 'sgfp' ),
      'singular_name'       => _x( 'Featured Property', 'Post Type Singular Name', 'sgfp' ),
      'menu_name'           => __( 'Featured Prop', 'sgfp' ),
      'parent_item_colon'   => __( 'Parent Featured Property:', 'sgfp' ),
      'all_items'           => __( 'All Featured Prop', 'sgfp' ),
      'view_item'           => __( 'View Featured Property', 'sgfp' ),
      'add_new_item'        => __( 'Add New Featured Property', 'sgfp' ),
      'add_new'             => __( 'Add New', 'sgfp' ),
      'edit_item'           => __( 'Edit Featured Property', 'sgfp' ),
      'update_item'         => __( 'Update Featured Property', 'sgfp' ),
      'search_items'        => __( 'Search Featured Properties', 'sgfp' ),
      'not_found'           => __( 'Featured Property Not found', 'sgfp' ),
      'not_found_in_trash'  => __( 'Not found in Trash', 'sgfp' ),
    );
    $args = array(
      'description'         => __( 'Featured Properties', 'sgfp' ),
      'labels'              => $prop_labels,
      'supports'            => array( 'title', 'excerpt', 'thumbnail', 'revisions' ),
      'rewrite'             => array( 'slug' => $this->cpt_slug ),
      'public'              => true,
      'show_ui'             => true,
      'show_in_menu'        => true,
      'show_in_nav_menus'   => true,
      'show_in_admin_bar'   => true,
      'menu_position'       => 7,
      'can_export'          => true,
      'has_archive'         => true,
      'exclude_from_search' => false,
      'publicly_queryable'  => true,
      'capability_type'     => 'post',
    );
    register_post_type( $this->cpt_slug, $args );
  }

  /**
   * Define the CPT taxonomies
   *
   * @since 1.0
   * @return void
   */
  public function fp_custom_taxonomy() {

    $neighborhood_labels = array(
      'name'              => _x('Neighborhoods', 'taxonomy general name', 'sgfp'),
      'singular_name'     => _x('Neighborhood', 'taxonomy singular name', 'sgfp'),
      'all_items'         => __('All Neighborhoods', 'sgfp'),
      'edit_item'         => __('Edit Neighborhood', 'sgfp'),
      'view_item'         => __('View Neighborhood', 'sgfp'),
      'update_item'       => __('Update Neighborhood', 'sgfp'),
      'add_new_item'      => __('Add New Neighborhood', 'sgfp'),
      'new_item_name'     => __('New Neighborhood', 'sgfp'),
      'search_items'      => __('Search Neighborhoods', 'sgfp')
    );

    $neighborhoods = array(
      "hierarchical"          => true,
      "labels"                => $neighborhood_labels,
      "show_ui"               => true,
      "show_admin_column"     => true,
      'update_count_callback' => '_update_post_term_count',
      "query_var"             => true,
      'rewrite'               => array( 'slug' => 'neighborhood' )
    );

    $status_labels = array(
      'name'          => _x('MLS Status', 'taxonomy general name', 'sgfp'),
      'singular_name' => _x('MLS Status', 'taxonomy singular name', 'sgfp'),
      'all_items'     => __('All MLS Status', 'sgfp'),
      'edit_item'     => __('Edit MLS Status', 'sgfp'),
      'view_item'     => __('View MLS Status', 'sgfp'),
      'update_item'   => __('Update MLS Status', 'sgfp'),
      'add_new_item'  => __('Add New MLS Status', 'sgfp'),
      'new_item_name' => __('New MLS Status', 'sgfp'),
      'search_items'  => __('Search MLS Status', 'sgfp')
    );

    $status = array(
      "hierarchical"          => false,
      "labels"                => $status_labels,
      "show_ui"               => true,
      "show_admin_column"     => true,
      'update_count_callback' => '_update_post_term_count',
      "query_var"             => true,
      'rewrite'               => array( 'slug' => 'status' )
    );

    register_taxonomy( 'status', array( $this->cpt_slug ), $status);
    register_taxonomy( 'neighborhood', array( $this->cpt_slug, 'buildings' ), $neighborhoods);
  }

} // END class
