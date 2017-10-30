<?php
/**
 * Filename: sg-featured-property-vars.php
 * @since 1.0
 * all the variables used by the Featured Property plugin
 */
  global $post;

  $status      = wp_get_post_terms($post->ID, 'status', array('fields' => 'all'));
  $stat_name   = $status[0]->name;
  $stat_slug   = $status[0]->slug;

  $cover_image     = rwmb_meta( 'props_cover_image', 'type=image_advanced');
  $slider_id       = rwmb_meta( 'props_slider' );
  $sub_title       = rwmb_meta( 'props_sub_title', 'type=text');
  $footer_text     = rwmb_meta( 'props_footer_text', 'type=text');
  $building_id     = rwmb_meta( 'props_building_name', 'type=select');
  $street_address  = rwmb_meta( 'props_street_address', 'type=text');
  $list_price      = rwmb_meta( 'props_list_price', 'type=text');
  $year_built      = rwmb_meta( 'props_year_built', 'type=number');
  $sq_footage      = rwmb_meta( 'props_sq_footage', 'type=text');
  $gallery_image   = rwmb_meta( 'props_list_gallery', 'type=image_advanced');
  $representing    = rwmb_meta( 'props_representing', 'type=checkbox_list'); // [0] = Seller, [1] = Buyer
  $mls_num         = rwmb_meta( 'props_mls_num', 'type=number');
  $visual_tour     = rwmb_meta( 'props_visual_tour_url', 'type=url');
  $marketing       = rwmb_meta( 'props_marketing', 'type=wysiwyg');
  $directions      = rwmb_meta( 'props_directions', 'type=wysiwyg');
  $sell_price      = rwmb_meta( 'props_sell_price', 'type=text');
  $prop_type       = rwmb_meta( 'props_prop_type', 'type=text');
  $bedrooms        = rwmb_meta( 'props_bedrooms', 'type=number');
  $bathrooms       = rwmb_meta( 'props_bathrooms', 'type=number');
  $parking         = rwmb_meta( 'props_parking', 'type=number');
  $ho_dues         = rwmb_meta( 'props_ho_dues', 'type=text');
  $annual_taxes    = rwmb_meta( 'props_annual_taxes', 'type=text');
  $tax_year        = rwmb_meta( 'props_tax_year', 'type=number');

  $price_label     = ($stat_slug == 'sold') ? __( 'Sold Price', 'fpcp' ) : __( 'List Price', 'fpcp' );
  $building_name   = $public->issetor($building_id) ? get_the_title($building_id) : '';
  $gd_image        = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'featured-prop-medium' );
  $neighborhood    = wp_get_post_terms($post->ID, 'neighborhood', array('fields' => 'all'));
  foreach ($neighborhood as $hood) {
    if ($hood->parent > 0) {
      $hood_name = $public->issetor($hood->name);
      $hood_slug = $public->issetor($hood->slug);
    }
  }

  if (! empty($hood_name)) $js_hood = lcfirst(str_replace(' ', '', $hood_name));
  $upload_dir   = wp_upload_dir();
  $map_dir      = '/neighborhoods/';
  $image_src    = ! empty($hood_slug) ? $upload_dir['baseurl']. $map_dir . $hood_slug . '.PNG' : '';
  $alt_text     = $public->issetor($building_name) ? $building_name : get_the_title();
  $past_present = ( $stat_slug == 'sold' ) ? __( 'Represented', 'fpcp' ) : __( 'Representing', 'fpcp' );

  if ( ! empty($representing[0]) && ! empty($representing[1]) ) {
    $repping = $past_present . __( ' the Buyer and the Seller', 'fpcp' );
  } elseif ( ! empty($representing[0]) && $representing[0] === 'Buyer' ) {
    $repping = $past_present . __( ' the Buyer', 'fpcp' );
  } elseif ( ! empty($representing[0]) && $representing[0] === 'Seller' )  {
    $repping = __( 'Presented Exclusively by', 'fpcp' ) . ' The Stroupe Group';
  } else {
    $repping = false;
  }

  $gallery_count = count($gallery_image);
  if ($gallery_count === 1) {
    $multiple_images = false;
  }
  elseif ($gallery_count > 1)
  {
    $multiple_images = true;
  }
  else {
    $multiple_images = NULL;
  }
