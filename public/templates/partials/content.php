<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.2
 */
sg_template_identifier('begin', __FILE__);

$public = new Sg_Featured_Property_Public( SGFP_PLUGIN_NAME, SGFP_PLUGIN_VERSION, SGFP_CPT_SLUG );
require SGFP_PLUGIN_DIR . 'public/templates/partials/sg-featured-property-vars.php';

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <?php
  if ( is_sticky() && is_home() ) :
    echo twentyseventeen_get_svg( array( 'icon' => 'thumb-tack' ) );
  endif;
  ?>
  <header class="entry-header">
    <?php
    if ( 'post' === get_post_type() ) {
      echo '<div class="entry-meta">';
        if ( is_single() ) {
          twentyseventeen_posted_on();
        } else {
          echo twentyseventeen_time_link();
          twentyseventeen_edit_link();
        };
      echo '</div><!-- .entry-meta -->';
    };

    if ( is_single() && get_post_type() == 'featured' ) {
    ?>
        <h1 data-title="<?php echo $public->issetor($stat_slug); ?>-listing"><?php echo __('Featured Properties ', 'sgfp') . '<br><small>' . get_the_title() . '</small>' ;?></h1>
    <?php
    } elseif ( is_single() ) {
      the_title( '<h1 class="entry-title">', '</h1>' );
    } elseif ( is_front_page() && is_home() ) {
      the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
    } else {
      the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
    }
    ?>
    <nav class="navbar navbar-justified">

      <a class="btn btn-default btn-ilona btn-md" href="<?php echo site_url('/contact/buyers/'); ?>"><?php _e( 'Thinking about Buying', 'sgfp' ); ?></a>
      <a class="btn btn-default btn-ilona btn-md" href="<?php echo site_url('/contact/sellers/'); ?>"><?php _e( 'Thinking about Selling', 'sgfp' ); ?></a>
      <a class="btn btn-primary btn-md navbar-right" href="<?php echo site_url('/contact/buyers/?interest=Thinking+about+buying&amp;referrer=' . $public->the_slug() ); ?>"><?php _e( 'Request showing / more info', 'sgfp' ); ?></a>

    </nav>

  </header><!-- .entry-header -->

  <?php if ( '' !== get_the_post_thumbnail() && ! is_single() ) : ?>
    <div class="post-thumbnail">
      <a href="<?php the_permalink(); ?>">
        <?php the_post_thumbnail( 'twentyseventeen-featured-image' ); ?>
      </a>
    </div><!-- .post-thumbnail -->
  <?php endif; ?>

  <div class="entry-content">
    <?php
    if ( is_single() && get_post_type() == 'featured' ) {
        if( ! empty($repping) ) {
          echo '<p class="SGFont mb-10">' . $repping . '</p>';
        }

        if ( ! empty($slider_id) || true == $multiple_images )  {
          // include SGFP_PLUGIN_DIR . "/public/partials/sg-featured-carousel.php";
        } elseif ( NULL == $multiple_images ) {
          // echo "<div class='featured-image'><img class='img-responsive center-block' src='$gd_image[0]' alt='$alt_text-featured' /></div>";
          echo '<div class="featured-image"><a href="'.$gd_image[0].'" class="item fresco">';
          echo '<img class="img-responsive center-block" src="'.$gd_image[0].'" alt="'.$alt_text.'-featured" />';
          echo '</a></div>';
          // if ( current_user_can( 'manage_options' ) ) {
          //   echo '$multiple_images is NOT null';
          // }
        } elseif ( false == $multiple_images ) {
          foreach ($gallery_image as $image) {
            echo "<div class='featured-image'><img class='img-responsive center-block' src='$image[url]' alt='$alt_text-gallery' /></div>";
          }
          // if ( current_user_can( 'manage_options' ) ) {
          //   echo '$multiple_images is false, so we are using $gallery_image';
          // }
        }

        if( ! empty($street_address) ):
          $pieces = explode(' ', $street_address);
        ?>
        <div class="street-address mt-10 mb-10">
          <p><?php echo $street_address; ?></p>
        </div>
        <?php endif ?>

        <?php if ( ! empty($visual_tour) || ! empty($building_id) ) { ?>
        <div class="pull-right mt-10">
        <?php if ( ! empty($building_id) ): ?>
          <a class="btn btn-primary mb-15" href="<?php echo get_the_permalink($building_id); ?>"><?php echo $building_name; ?> Building Profile</a>
        <?php endif ?>
        <?php if ( ! empty($visual_tour) ): ?>
          <a class="btn btn-primary mb-15" href="<?php echo $visual_tour; ?>" target="_blank"><?php _e( 'View the Visual Tour', 'sgfp' ); ?></a>
        <?php endif ?>
        </div>
        <?php } ?>

        <div style="clear: both;"></div>

        <div role="tabpanel">
            <ul id="location-tabs" class="dark-menu nav nav-pills nav-justified col-md-12 mb-10" data-tabs="tabs" role="tablist">
                <li role="presentation" class="active"><a href="#property-details" role="tab" data-toggle="tab"><?php _e( 'Details', 'sgfp' ); ?></a></li>
                <li role="presentation"><a href="#street-map" role="tab" data-toggle="tab"><?php _e( 'Map / Satellite', 'sgfp' ); ?></a></li>
                <li role="presentation"><a href="#walk-score" role="tab" data-toggle="tab"><?php _e( 'Walk Score', 'sgfp' ); ?></a></li>
                <?php if ( !empty($hood_name) ) { ?>
                <li role="presentation"><a id="neighborhood-link" href="#neighborhood-idx" role="tab" data-toggle="tab"><?php _e( 'Neighborhood', 'sgfp' ); ?></a></li>
                <?php } ?>

            </ul>
            <div id="location-tab-content" class="row tab-content">

                <!-- PROPERTY DETAILS -->
                <div id="property-details" class="tab-pane active">
                  <div class="col-md-12 col-sm-12">

                    <div id="detailsMainInfo" class="panel panel-primary">
                      <div class="panel-heading">
                          <h4 class="field-listingID">
                              <span class="idx-label"><?php _e( 'MLS Listing Number', 'sgfp' ); ?>: </span>
                              <span class="idx-text"><?php echo $mls_num; ?></span>
                          </h4>

                      </div>
                      <div class="list-group row">
                        <div class="col-md-6 col-sm-12">
                          <?php if ( ! empty($list_price) ): ?>
                            <div class="field-listingPrice field-price list-group-item">
                                <span class="idx-label"><?php echo $price_label; ?>: </span>
                                <span class="idx-text">$<?php echo $list_price; ?></span>
                            </div>
                          <?php endif ?>

                          <?php if ( ! empty($hood_name) ): ?>
                            <div class="field-neighborhood list-group-item">
                                <span class="idx-label"><?php _e( 'Neighborhood', 'sgfp' ); ?>: </span>
                                <span class="idx-text"><?php echo $hood_name; ?></span>
                            </div>
                          <?php endif ?>

                          <?php if ( ! empty($prop_type) ): ?>
                            <div class="field-idxPropType list-group-item">
                                <span class="idx-label"><?php _e( 'Property Type', 'sgfp' ); ?>: </span>
                                <span class="idx-text"><?php echo $prop_type; ?></span>
                            </div>
                          <?php endif ?>

                          <?php if ( ! empty($building_name) ): ?>
                            <div class="field-building list-group-item">
                                <span class="idx-label"><?php _e( 'Building', 'sgfp' ); ?>: </span>
                                <span class="idx-text"><a href="<?php echo get_the_permalink($building_id); ?>"><?php echo $building_name; ?></a></span>
                            </div>
                          <?php endif ?>

                          <?php if ( ! empty($bedrooms) ): ?>
                            <div class="field-bedrooms list-group-item">
                                <span class="idx-label"><?php _e( 'Bedrooms', 'sgfp' ); ?>: </span>
                                <span class="idx-text"><?php echo $bedrooms; ?></span>
                            </div>
                          <?php endif ?>

                          <?php if ( ! empty($bathrooms) ): ?>
                            <div class="field-totalBaths list-group-item">
                                <span class="idx-label"><?php _e( 'Bathrooms', 'sgfp' ); ?>: </span>
                                <span class="idx-text"><?php echo $bathrooms; ?></span>
                            </div>
                          <?php endif ?>

                          <?php if ( ! empty($sq_footage) ): ?>
                            <div class="field-sqFt list-group-item">
                                <span class="idx-label"><?php _e( 'Square Feet', 'sgfp' ); ?>: </span>
                                <span class="idx-text"><?php echo $sq_footage; ?></span>
                            </div>
                          <?php endif ?>
                        </div>
                        <div class="col-md-6 col-sm-12">

                          <?php if ( ! empty($year_built) ): ?>
                            <div class="field-yearBuilt list-group-item">
                                <span class="idx-label"><?php _e( 'Year Built', 'sgfp' ); ?>: </span>
                                <span class="idx-text"><?php echo $year_built; ?></span>
                            </div>
                          <?php endif ?>

                          <?php if ( ! empty($stat_name) ): ?>
                            <div class="field-propStatus list-group-item">
                                <span class="idx-label"><?php _e( 'Status', 'sgfp' ); ?>: </span>
                                <span class="text <?php echo $stat_slug; ?>"><?php echo $stat_name; ?></span>
                            </div>
                          <?php endif ?>

                          <?php if ( ! empty($parking) ): ?>
                            <div class="field-numberOfAssignedSpaces list-group-item">
                                <span class="idx-label"><?php _e( 'Parking', 'sgfp' ); ?>: </span>
                                <span class="idx-text"><?php echo $parking; ?></span>
                            </div>
                          <?php endif ?>

                          <?php if ( ! empty($ho_dues) ): ?>
                            <div class="field-homeOwnerDues list-group-item">
                                <span class="idx-label"><?php _e( 'Home Owner Dues', 'sgfp' ); ?>: </span>
                                <span class="idx-text">$<?php echo $ho_dues; ?></span>
                            </div>
                          <?php endif ?>

                          <?php if ( ! empty($annual_taxes) ): ?>
                            <div class="field-annualTaxes list-group-item">
                                <span class="idx-label"><?php _e( 'Annual Taxes', 'sgfp' ); ?>: </span>
                                <span class="idx-text">$<?php echo $annual_taxes; ?></span>
                            </div>
                          <?php endif ?>

                          <?php if ( ! empty($tax_year) ): ?>
                            <div class="field-taxYear list-group-item">
                                <span class="idx-label"><?php _e( 'Tax Year', 'sgfp' ); ?>: </span>
                                <span class="idx-text"><?php echo $tax_year; ?></span>
                            </div>
                          <?php endif ?>

                        </div>

                      </div>
                    </div><!-- #detailsMainInfo -->

                    <?php if ( ! empty($marketing) ): ?>
                      <div id="description" class="well well-lg mb-0">
                        <p><?php echo $marketing; ?></p>
                      </div>
                    <?php endif ?>

                  </div>
                </div>

                <!-- MAP -->
                <div id="street-map" class="tab-pane" data-listing="<?php echo $mls_num; ?>" data-name="<?php echo $building_name; ?>">
                  <div class="col-md-12 col-sm-12">
                      <div id="loc-map" style="height: 340px; width: 100%; border-radius: 7px">
                          <!-- auto-populated by map script -->
                      </div>
                  </div>
                </div><!-- #street-map -->

                <!-- WALK SCORE -->
                <div id="walk-score" class="tab-pane">
                  <div class="col-md-12 col-sm-12">
                    <div class="radius light-background">
                      <script>
                        var ws_wsid = '009378be618a44e081e95315e605cc99';
                        var ws_address = '<?php echo $street_address; ?>';
                        var ws_width = '100%'; // responsive layout
                        var ws_height = '340';
                        var ws_layout = 'none'; // starts horizontal, becomes vertical on phones
                        var ws_commute = 'true';
                        var ws_transit_score = 'true';
                        var ws_map_modules = 'all';
                        var ws_base_map = "google_map"; //walkability
                      </script>
                      <div id='ws-walkscore-tile'>
                          <div id='ws-footer' style='position:absolute;top:482px;left:3px;width:494px'>
                              <form id='ws-form'><span id='ws-foottext' style='float: left;'>Score <a id='ws-a' href='https://www.redfin.com/how-walk-score-works' target='_blank'>Your Home</a>: </span>
                                  <input type='text' id='ws-street' style='position:absolute;top:0px;left:170px;width:292px' />
                                  <input type='image' id='ws-go' src='//cdn2.walk.sc/2/images/tile/go-button.gif' height='15' width='22' border='0' alt='get my Walk Score' style='position:absolute;top:0px;right:0px' />
                              </form>
                          </div>
                      </div>
                      <script src='https://www.walkscore.com/tile/show-walkscore-tile.php'></script>
                    </div>xzAZ                                  VBC
                  </div>
                </div><!-- #walk-score -->

                <?php if ( ! empty($hood_name) && ! empty($hood_slug) ) {
                  $image_src = $upload_dir['baseurl']. $map_dir . $hood_slug . '.PNG';
                ?>

                <!-- NEIGHBORHOOD -->
                <div id="neighborhood-idx" class="tab-pane">
                  <div class="col-md-12 col-sm-12">
                    <h3 class="pull-left"><?php echo $hood_name; ?></h3>
                    <div class="pull-right mb-20">
                      <a href="http://searchproperties.stroupe.com/i/<?php echo $hood_slug ?>" class="btn btn-ilona"><?php _e( 'View Active Listings', 'sgfp' ); ?></a>
                    </div>
                    <div>
                      <img src="<?php echo $image_src; ?>" alt="<?php echo $hood_slug; ?>  neighborhood map">
                    </div>
                  </div>
                </div><!-- #neighborhood -->
                <?php } ?>
            </div><!-- #location-tab-content -->
        </div><!-- role = tabpanel -->

<?php
    } //endif
    /* translators: %s: Name of current post */
    the_content( sprintf(
      __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentyseventeen' ),
      get_the_title()
    ) );

    wp_link_pages( array(
      'before'      => '<div class="page-links">' . __( 'Pages:', 'twentyseventeen' ),
      'after'       => '</div>',
      'link_before' => '<span class="page-number">',
      'link_after'  => '</span>',
    ) );
    ?>
  </div><!-- .entry-content -->

  <?php
  if ( is_single() ) {
    twentyseventeen_entry_footer();
  }
  ?>

</article><!-- #post-## -->
<?php
sg_template_identifier('end', __FILE__);
 ?>
