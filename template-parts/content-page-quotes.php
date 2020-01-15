<?php
  global $isLastSection;
  $quotes = get_sub_field('quotes');
  $asSlideshow = get_sub_field('quotes-slideshow');
  $rand = bin2hex(random_bytes(4));
  $id = 'quotes-' . $rand;
?>
<section class="section-quotes<?= $isLastSection ? ' last' : '' ?>" id="quotes-<?= $id ?>" data-as-slideshow="<?= $asSlideshow ? 'true' : 'false' ?>">
	<div class="inner">
    <?php
      if(have_rows('quotes')) :
        while(have_rows('quotes')) : the_row();
          $name = get_sub_field('brand-name');
          $logo = get_sub_field('brand-logo');
          $quote = get_sub_field('quote');
          $logoFile = get_template_directory() . '/assets/svg/' . $logo . '-logo.svg';
    
    ?>
    <div class="quote">
      <div class="inner">
        <?php if(file_exists($logoFile)) : ?><div class="logo"><?php require($logoFile) ?></div><?php endif; ?>
        <h3 class="name"><?= $name ?></h3>
        <div class="body"><?= $quote; ?></div>
      </div>
    </div>
    <?php
        endwhile;
      endif;
    ?>
  </div>
</section>
