<div class="folio_mask">
  <div class="folio_caption">
    <div>
      <div><?php the_title(); ?></div>
    </div>
  </div><!-- END - .folio_caption -->
  <div class="folio_desc">
    <div class="desc_body">
      <div class="FPproperty">
      <?php
        if ( ! empty($hood_name) ) {
          echo "<h2>$hood_name</h2>";
        }
        if( ! empty($repping) ) {
          echo '<p class="SGFontEXPT mb-10">' . $repping . '</p>';
        }

        ?>
        <h6 class="FPaddress"><?php echo $street_address; ?></h6>
        <div class="Hline"></div>
        <div class="FP_BL">
          <p><?php echo $price_label; ?>:</p>
          <p><?php _e( 'SQUARE FOOTAGE', 'fpcp' ); ?>:</p>
          <p><?php _e( 'YEAR BUILT', 'fpcp' ); ?>:</p>
        </div>
        <div class="FP_BR">
          <p>$<?php echo $list_price; ?></p>
          <p><?php echo $sq_footage; ?></p>
          <p><?php echo $year_built; ?></p>
        </div>
        <h4><?php echo ucwords($footer_text); ?></h4>
      </div><!-- END - .FPproperty -->
    </div><!-- END - .desc_body -->
    <div class="goto_post">
      <a href="#" class="go_more"></a>
    </div>
  </div><!-- END - .folio_desk -->
</div><!-- end .folio_mask -->
<div class="folio_just_caption">
  <div>
    <div><?php the_title(); ?></div>
  </div>
</div><!-- END - .folio_just_caption -->
