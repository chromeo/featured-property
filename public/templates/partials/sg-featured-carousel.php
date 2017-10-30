<!-- Gallery -->
<div role="tabpanel" id="gallery" class="row row-eq-height tab-pane active">
  <div class="col-xs-12 clear">
  <?php
  if ( function_exists( 'slider_pro' ) && $slider_id ) {

    echo slider_pro( $slider_id ); ?>

    <script type="text/javascript">
    /* global jQuery */
      jQuery(document).ready(function ($) {
        $('.slider-pro .slide').each(function () {
          var href = $(this).children('img').attr('src')
          $(this).attr('href', href).attr('data-fresco-group', 'gallery-<?php echo $slider_id; ?>').attr('data-fresco-options', "thumbnail: '" + href + "'").addClass('fresco')
        })

        // $('.slider-pro .slides').attr('data-featherlight-gallery', '').attr('data-featherlight-filter', 'div')
        // $('.slider-pro .image').featherlightGallery({
        //   targetAttr: 'src',
        //   variant: 'remodal minimal-dark',             /* Class that will be added to change look of the lightbox */
        //   resetCss: false,                 /* Reset all css */
        //   background: null,                  /* Custom DOM for the background, wrapper and the closebutton */
        //   // previousIcon: '<a class="previous" aria-hidden="true"></a>',     /* Code that is used as previous icon */
        //   // nextIcon: '<a class="next" aria-hidden="true"></a>',         /* Code that is used as next icon */
        //   previousIcon: '<i class="fa fa-angle-left" aria-hidden="true"></i>',      /* Code that is used as previous icon*/
        //   nextIcon: '<i class="fa fa-angle-right" aria-hidden="true"></i>',         /* Code that is used as next icon */
        //   closeIcon: '&times;'
        // })
      })
    </script>
  <?php } else {
  // no slider, so we must have a gallery
  ?>
    <div id="carousel-property" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <?php
        $i  = 0;
        foreach ($gallery_image as $image) {
          echo '<li data-target="#carousel-property" data-slide-to="'.$i.'"></li>';
          $i++;
        }
        ?>
      </ol>
      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
        <?php
        $id = get_the_ID();
        $j  = 1;
        foreach ($gallery_image as $image) {
          echo '<a href="'.$image[ 'url'].'" class="item fresco" data-fresco-group="gallery-'.$id.'" data-fresco-options="thumbnail: &#39;' . $image[ 'url'] . '&#39;">';
          echo '<img class="img-responsive center-block" src="'.$image[ 'url'].'" alt="'.$building_name.'" />';
          echo '</a>';
          $j++;
        }
        ?>
      </div>
      <!-- Left and right controls -->
      <a class="left carousel-control" href="#carousel-property" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#carousel-property" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
  <?php } ?>
  </div>
</div>
<!-- #gallery -->
