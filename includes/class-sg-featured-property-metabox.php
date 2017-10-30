<?php
/**
 * The file that defines the featured property metabox
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/chromeo
 * @since      1.0.0
 * @package    Sg_Featured_Property
 * @subpackage Sg_Featured_Property/includes
 * @author     Gary Darling <garydarling@gmail.com>
 **/

class Sg_Featured_Property_Metabox {

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
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $cpt_slug ) {

        $this->cpt_slug = $cpt_slug;

    }

    /**
     * Grab the names and ids of our buildings created in the Buildings plugin.
     *
     * @since    1.0.0
     * @access   private
     * @return   array
     */
    public function get_building_profiles() {

        $args = array(
            'post_type' => 'buildings', // this needs to match the post type name created by the Buildings plugin. TODO: dynamic or selectable
            'posts_per_page' => -1,
            'order' => 'ASC',
            'orderby' => 'title'
        );
        $loop = new WP_Query($args);
        $options = array();

        while($loop->have_posts()): $loop->the_post();
            $title        = the_title_attribute('echo=0');
            $id           = get_the_ID();
            $options[$id] = $title;

        endwhile;
        wp_reset_query();

        return $options;
    }


    /**
     * Register meta boxes
     *
     * Remember to change "your_prefix" to actual prefix in your project
     *
     * @param array $meta_boxes List of meta boxes
     * @link http://metabox.io/docs/registering-meta-boxes/
     * @return array
     */
    public function props_register_meta_boxes( $meta_boxes ) {
    	/**
    	 * prefix of meta keys (optional)
    	 * Use underscore (_) at the beginning to make keys hidden
    	 * Alt.: You also can make prefix empty to disable it
    	 */
    	// Better have an underscore as last sign
      $profiles = $this->get_building_profiles();

      $prefix = 'props_';

    	$meta_boxes[] = array(
        'id'         => 'home',
        'title'      => __( 'Featured Properties Home', 'meta-box' ),
        'post_types' => array( $this->cpt_slug ),
        'context'    => 'normal',
        'priority'   => 'high',
        'autosave'   => true,
        'tabs'       => array(
          'cover'			=> array(
            'label'			=> __( 'Cover Details', 'meta-box' ),
            'icon'			=> 'dashicons-book-alt',
          ),
          'inside'		=> array(
            'label'			=> __( 'Inside Details', 'meta-box' ),
            'icon'			=> 'dashicons-welcome-write-blog',
          ),
        ),
            // Tab style: 'default', 'box' or 'left'. Optional
        'tab_style'	=> 'default',
        'fields'	=> array(

    /*---------------------------------- Summary meta box -------------------------------------*/
    			// IMAGE ADVANCED - Cover Image
    			array(
            'name'             => __( 'Cover Image', 'meta-box' ),
            'id'               => "{$prefix}cover_image",
            'type'             => 'image_advanced',
            'columns'          => 4,
            'max_file_uploads' => 4,
            'tab'              => 'cover',
    			),
    			// TEXT - Sub Title
    			array(
            'name'    => __( 'SEO Sub Title', 'meta-box' ),
            'id'      => "{$prefix}sub_title",
            'type'    => 'text',
            'desc'    => __( 'ex: Stunning Penthouse Unit at the Parc', 'meta-box' ),
            'columns' => 4,
            'clone'   => false,
            'add_to_wpseo_analysis' => true,
            'tab'     => 'cover',
    			),
    			// NUMBER - Additional Text
    			array(
            'name'    => __( 'SEO Footer Text', 'meta-box' ),
            'id'      => "{$prefix}footer_text",
            'type'    => 'text',
            'desc'    => __( 'ex: Near Pike Place Market', 'meta-box' ),
            'columns' => 4,
            'add_to_wpseo_analysis' => true,
            'tab'     => 'cover',
    			),
    //~~ New row ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    			// DIVIDER
    			array(
            'type' => 'divider',
            'id'   => 'fake_divider_0', // Not used, but needed
            'tab'  => 'cover',
    			),
          // SELECT BOX - Building Name
          array(
            'name'        => __( 'Building Name', 'meta-box' ),
            'id'          => "{$prefix}building_name",
            'type'        => 'select',
            'columns'     => 6,
            'multiple'    => false,
            'std'         => 'None',
            'placeholder' => __( 'Select a building...', 'meta-box' ),
            'tab'         => 'cover',
            'add_to_wpseo_analysis' => true,
            'options'     => $profiles,
          ),
    			// TEXT - Street Address
    			array(
            'name'    => __( 'Primary Address', 'meta-box' ),
            'id'      => "{$prefix}street_address",
            'type'    => 'text',
            'desc'    => __( 'ex: 76 Cedar Street, Seattle WA, 98121<br>Do NOT include the unit number', 'meta-box' ),
            'columns' => 6,
            'clone'   => false,
            'add_to_wpseo_analysis' => true,
            'tab'     => 'cover',
    			),
    //~~ New row ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    			// DIVIDER
    			array(
            'type' => 'divider',
            'id'   => 'fake_divider_1', // Not used, but needed
            'tab'  => 'cover',
    			),
    			// NUMBER - Listing Price
    			array(
            'name'    => __( 'Listing Price', 'meta-box' ),
            'id'      => "{$prefix}list_price",
            'type'    => 'text',
            'desc'    => __( 'Add commas, but not $ sign', 'meta-box' ),
            'columns' => 4,
            'tab'     => 'cover',
    			),
    			// NUMBER - Year Built
    			array(
            'name'    => __( 'Year Built', 'meta-box' ),
            'id'      => "{$prefix}year_built",
            'type'    => 'number',
            'columns' => 4,
            'min'     => 1900,
            'step'    => 1,
            'tab'     => 'cover',
    			),
    			// NUMBER - Square Footage
    			array(
            'name'    => __( 'Square Footage', 'meta-box' ),
            'id'      => "{$prefix}sq_footage",
            'type'    => 'text',
            'columns' => 4,
            'tab'     => 'cover',
    			),
    # -------------------------------------------------------|
    ##~~ New tab ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ |
    # -------------------------------------------------------|

    			// NUMBER - Slider Pro number
    			array(
            'name'    => __( 'Slideshow number', 'meta-box' ),
            'id'      => "{$prefix}slider",
            'type'    => 'number',
            'desc'    => 'Note: if you enter a slideshow number, this slideshow will be used instead of the Listing Gallery Images to the right',
            'columns' => 3,
            'min'     => 0,
            'step'    => 1,
            'tab'     => 'inside',
    			),
                // CHECKBOX List - Buyer and Seller
                array(
            'name'    => __( 'Representing:', 'meta-box' ),
            'id'      => "{$prefix}representing",
            'type'    => 'checkbox_list',
            'columns' => 3,
            'tab'     => 'inside',
            'options' => array(
            'Buyer'   => __( 'Buyer', 'meta-box' ),
            'Seller'  => __( 'Seller', 'meta-box' ),
                    ),
                ),
                // IMAGE ADVANCED - Building Gallery Images
                array(
            'name'             => __( 'Listing Gallery Images', 'meta-box' ),
            'id'               => "{$prefix}list_gallery",
            'type'             => 'image_advanced',
            'desc'             => 'Use this if you don\'t have a Slider, and you don\'t want to use the Featured Image. If you have a Featured Image, you can leave this empty.',
            'columns'          => 6,
            'max_file_uploads' => 30,
            'tab'              => 'inside',
                ),
    //~~ New row ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    			// DIVIDER
    			array(
            'type' => 'divider',
            'id'   => 'fake_divider_2', // Not used, but needed
            'tab'  => 'inside',
    			),
    			// NUMBER - MLS number
    			array(
            'name'    => __( 'MLS number', 'meta-box' ),
            'id'      => "{$prefix}mls_num",
            'type'    => 'number',
            'columns' => 6,
            'min'     => 1900,
            'step'    => 1,
            'tab'     => 'inside',
    			),
    			// TEXT - Visual Tour URL
    			array(
            'name'    => __( 'Visual Tour URL', 'meta-box' ),
            'id'      => "{$prefix}visual_tour_url",
            'type'    => 'url',
            'desc'    => __( 'Enter a url where the user goes when they click the Visual Tour button', 'meta-box' ),
            'columns' => 6,
            'clone'   => false,
            'tab'     => 'inside',
    			),
    //~~ New row ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    			// DIVIDER
    			array(
            'type' => 'divider',
            'id'   => 'fake_divider_3', // Not used, but needed
            'tab'  => 'inside',
    			),
    			// TEXTAREA - Marketing remarks
    			array(
            'name'    => __( 'Marketing remarks', 'meta-box' ),
            'desc'    => __( '<b>Marketing text</b><br>This text will be <mark>analyzed by Yoast SEO</mark>', 'meta-box' ),
            'id'      => "{$prefix}marketing",
            'type'    => 'wysiwyg',
            'columns' => 6,
            'raw'     => true,
            'tab'     => 'inside',
            'add_to_wpseo_analysis' => true,
    				'options'	=> array(
              'textarea_rows' => 4,
              'teeny'         => true,
              'media_buttons' => false,
    				),
    			),
    			// TEXTAREA - Driving Directions
    			array(
            'name'    => __( 'Driving Directions', 'meta-box' ),
            'desc'    => __( '<b>Optional Driving Directions at the bottom</b><br>This text will be <mark>analyzed by Yoast SEO</mark>', 'meta-box' ),
            'id'      => "{$prefix}directions",
            'type'    => 'wysiwyg',
            'columns' => 6,
            'raw'     => true,
            'add_to_wpseo_analysis' => true,
            'tab'     => 'inside',
    				'options'	=> array(
              'textarea_rows' => 4,
              'teeny'         => true,
              'media_buttons' => false,
    				),
    			),
    //~~ New row ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    			// DIVIDER
    			array(
            'type' => 'divider',
            'id'   => 'fake_divider_4', // Not used, but needed
            'tab'  => 'inside',
    			),
    			// TEXT - Sell Price
    			array(
            'name'    => __( 'Sell Price', 'meta-box' ),
            'id'      => "{$prefix}sell_price",
            'type'    => 'text',
            'columns' => 3,
            'tab'     => 'inside',
    			),
    			// TEXT - Property Type
    			array(
            'name'    => __( 'Property Type', 'meta-box' ),
            'id'      => "{$prefix}prop_type",
            'type'    => 'text',
            'desc'    => __( 'ex: Condominium', 'meta-box' ),
            'columns' => 3,
            'tab'     => 'inside',
    			),
    			// NUMBER - Bedrooms
    			array(
            'name'    => __( 'Bedrooms', 'meta-box' ),
            'id'      => "{$prefix}bedrooms",
            'type'    => 'number',
            'columns' => 3,
            'min'     => 0,
            'step'    => 1,
            'tab'     => 'inside',
    			),
    			// NUMBER - Bathrooms
    			array(
            'name'    => __( 'Bathrooms', 'meta-box' ),
            'id'      => "{$prefix}bathrooms",
            'type'    => 'text',
            'columns' => 3,
            'tab'     => 'inside',
    			),
    //~~ New row ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    			// DIVIDER
    			array(
            'type' => 'divider',
            'id'   => 'fake_divider_5', // Not used, but needed
            'tab'  => 'inside',
    			),
    			// NUMBER - Parking Spaces
    			array(
            'name'    => __( 'Parking Spaces', 'meta-box' ),
            'id'      => "{$prefix}parking",
            'type'    => 'number',
            'columns' => 3,
            'min'     => 0,
            'step'    => 1,
            'tab'     => 'inside',
    			),
    			// TEXT - HO Dues
    			array(
            'name'    => __( 'Home Owner Dues', 'meta-box' ),
            'id'      => "{$prefix}ho_dues",
            'type'    => 'text',
            'columns' => 3,
            'tab'     => 'inside',
    			),
    			// TEXT - Annual Taxes
    			array(
            'name'    => __( 'Annual Taxes', 'meta-box' ),
            'id'      => "{$prefix}annual_taxes",
            'type'    => 'text',
            'columns' => 3,
            'tab'     => 'inside',
    			),
    			// NUMBER - Tax Year
    			array(
            'name'    => __( 'Tax Year', 'meta-box' ),
            'id'      => "{$prefix}tax_year",
            'type'    => 'number',
            'columns' => 3,
            'min'     => 2000,
            'step'    => 1,
            'tab'     => 'inside',
    			),
    //~~ End of the road ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    		) // fields
    	); // meta_boxes
    	return $meta_boxes;
    }

}
