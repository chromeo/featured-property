<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header();

sg_template_identifier('begin',__FILE__);
?>

<div class="wrap">
  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

      <?php
      /* Start the Loop */
      while ( have_posts() ) : the_post();

        require_once SGFP_PLUGIN_DIR . 'public/templates/partials/content.php';

        the_post_navigation( array(
          'prev_text' => '<span class="screen-reader-text">' . __( 'Previous Post', 'twentyseventeen' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Previous', 'twentyseventeen' ) . '</span> <span class="nav-title"><span class="nav-title-icon-wrapper">' . twentyseventeen_get_svg( array( 'icon' => 'arrow-left' ) ) . '</span>%title</span>',
          'next_text' => '<span class="screen-reader-text">' . __( 'Next Post', 'twentyseventeen' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Next', 'twentyseventeen' ) . '</span> <span class="nav-title">%title<span class="nav-title-icon-wrapper">' . twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ) . '</span></span>',
        ) );

      endwhile; // End of the loop.
      ?>

    </main><!-- #main -->
  </div><!-- #primary -->
  <?php get_sidebar(); ?>
</div><!-- .wrap -->
<script>
  var address = '<?php echo $public->issetor($street_address); ?>' // required for map
  var infoAddress = '<?php echo $public->issetor($pieces[0]) ." ". $public->issetor($pieces[1]) ." ". $public->issetor($pieces[2]) ."<br>". $public->issetor($pieces[3]) ." ". $public->issetor($pieces[4]) ." ". $public->issetor($pieces[5]); ?>'
  var buildingName = '<?php echo $public->issetor($building_name); ?>'
  var hoodName = '<?php echo $public->issetor($js_hood); ?>'
  var numUnits = ''
  var postType = '<?php echo get_post_type(); ?>'
  var styles = [
    {
      featureType: 'all',
      elementType: 'all',
      stylers: [
        { invert_lightness: true }
      ]
    }
  ]
  var mapDiv = 'loc-map'
  var mapOptions = {
    zoom: 14,
    center: {lat: 47.604686, lng: -122.329310},
    styles: styles
  }

  jQuery(document).ready(function ($) {
    // call init when the map tab is clicked, otherwise map tiles don't load properly
    $("a[href='#street-map']").on('shown.bs.tab', function () {
      googleMapInit(address, buildingName, numUnits, infoAddress, postType, mapDiv, mapOptions)
    })

    // hilight the active tab
    $('#location-map').click(function () {
      $(".nav-tabs a[href='#location']").parent('li').addClass('active')
      $(".nav-tabs a[href='#location']").parent('li').siblings().removeClass('active')
    })

    // Bootstrap logic to show the correct panel when a tab is clicked
    $('.nav-tabs a').click(function (e) {
      e.preventDefault()
      $(this).tab('show')
    })
  }) // end ready
</script>
<?php
sg_template_identifier('end',__FILE__);
get_footer();
