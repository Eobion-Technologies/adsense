<?php

/**
 * @file
 * Theme Managed ad block.
 *
 * This is exactly the same as core's modules/block/block.tpl.php, except
 * for the removal of the 'adsense' word in the block identifier and classes.
 * We do this to prevent adblockers from easily detecting the blocks created
 * by this module.
 */
?>
<div id="<?php print str_replace('adsense', '', $block_html_id); ?>" class="<?php print str_replace('adsense', '', $classes); ?>"<?php print $attributes; ?>>

  <?php print render($title_prefix); ?>
<?php if ($block->subject): ?>
  <h2<?php print $title_attributes; ?>><?php print $block->subject ?></h2>
<?php endif;?>
  <?php print render($title_suffix); ?>

  <div class="content"<?php print $content_attributes; ?>>
    <?php print $content ?>
  </div>
</div>
