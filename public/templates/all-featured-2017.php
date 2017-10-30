<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
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

  <?php if ( have_posts() ) : ?>
    <header class="page-header">
      <?php
        the_archive_title( '<h1 class="page-title">', '</h1>' );
        the_archive_description( '<div class="taxonomy-description">', '</div>' );
      ?>
    </header><!-- .page-header -->
  <?php endif; ?>

  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

    <?php
    if ( have_posts() ) : ?>
      <?php
      /* Start the Loop */
      while ( have_posts() ) : the_post();

        require SGFP_PLUGIN_DIR . 'public/templates/partials/content.php';

      endwhile;

      the_posts_pagination( array(
        'prev_text' => twentyseventeen_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous page', 'twentyseventeen' ) . '</span>',
        'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'twentyseventeen' ) . '</span>' . twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ),
        'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyseventeen' ) . ' </span>',
      ) );

    else : ?>

      <section class="no-results not-found">
        <header class="page-header">
          <h1 class="page-title"><?php _e( 'Nothing Found', 'twentyseventeen' ); ?></h1>
        </header>
        <div class="page-content">
          <?php
          if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

            <p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'twentyseventeen' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

          <?php else : ?>

            <p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'twentyseventeen' ); ?></p>
            <?php
              get_search_form();

          endif; ?>
        </div><!-- .page-content -->
      </section><!-- .no-results -->

    <?php endif; ?>

    </main><!-- #main -->
  </div><!-- #primary -->
  <?php get_sidebar(); ?>
</div><!-- .wrap -->

<?php
sg_template_identifier('end',__FILE__);
get_footer();
