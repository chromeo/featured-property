<?php
/**
* Template Name: 1 - All Featured Properties
 * Filename: all-featured.php
 * @since 1.0.4
*/
get_header();
get_sidebar();
sg_template_identifier('begin',__FILE__);

$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
$args = array(
    'paged'                  => $paged,
    'posts_per_archive_page' => 12,
    'post_type'              => SGFP_CPT_SLUG
);
$loop = new WP_Query( $args );
/*
 * If you need your pagination above the loop,
 * this is the earliest to add it. You cannot add it above
 */
?>
<div id="page-title" class="ubermenu ubermenu-responsive-default">
    <h1><?php _e('Featured Properties', 'sgfp'); ?></h1>
    <p><?php _e('We are proud to showcase our featured listings from the', 'sgfp'); ?> Stroupe Group</p>
    <div class="mt-20">
        <?php
        next_posts_link( __( 'Next Group', 'sgfp' ), $loop->max_num_pages );
        previous_posts_link( __( 'Previous Group', 'sgfp' ) );
        ?>
    </div>
</div>

<div id="content">
    <div id="multicol" class="masonry" style="position: relative; height: 2022px;">
    <?php
    while ( $loop->have_posts() ) : $loop->the_post();
        $public = new Sg_Featured_Property_Public( SGFP_PLUGIN_NAME, SGFP_PLUGIN_VERSION, SGFP_CPT_SLUG );
        require SGFP_PLUGIN_DIR . 'public/templates/partials/sg-featured-property-vars.php';
        ?>
        <div class="with_href portfolio folio_box col_m col_p masonry-brick" href="<?php the_permalink(); ?>">
            <a style="display: none;"></a>
            <div class="ribbon status-<?php echo $status[0]->slug; ?>"></div>
                <div class="folio" style="background: url(<?php echo $gd_image[0] ?>) 0 0 no-repeat; height:300px; background-size: cover;">
                <?php require SGFP_PLUGIN_DIR . 'public/templates/partials/sg-folio-part.php'; ?>
            </div><!-- end .folio -->
        </div>
    <?php
    // destroy_featured_vars();
    endwhile;
    wp_reset_postdata();
    ?>
    </div><!-- end #multicol -->
    <div class="row ubermenu-responsive-default ubermenu">
        <?php
        next_posts_link( __( 'Next Group', 'sgfp' ), $loop->max_num_pages );
        previous_posts_link( __( 'Previous Group', 'sgfp' ) );
        ?>
    </div>
    <section class="page-text well">
    <?php the_content(); ?>
    </section>
</div><!-- end #content -->

<?php
sg_template_identifier('end',__FILE__);
get_footer();
?>
