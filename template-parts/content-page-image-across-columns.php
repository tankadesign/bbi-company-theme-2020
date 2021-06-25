<?php
  global $isLastSection;
  $image = get_sub_field('image');
  $imageMobile = get_sub_field('image_mobile');
  $columns = (int) get_sub_field('image-columns');
  $position = get_sub_field('image-position');
  $fill = get_sub_field('image-fill');
  $title = get_sub_field('image-title');
  $body = get_sub_field('image-body');
  $valign = get_sub_field('text-valign');
  $imgStyles = [];
  $txtStyles = [];
  $imgFillStyles = [];
  $maxCols = 4;
  $pcts = [0, 25, 33.33333, 75];
  $imgStyles[] = 'flex: 1';
  $txtStyles[] = 'flex: 0 1 ' . $pcts[($maxCols - $columns)] . '%';
  $imgStyles[] = 'order: ' . ($position === 'left' ? 1 : 2);
  $txtStyles[] = 'order: '. ($position === 'left' ? 2 : 1);
  $txtStyles[] = 'display: flex; align-items: ' . $valign;
  $hasMobileImage = !empty($imageMobile) && !empty($imageMobile['url']);
  $fillBG = 'fill-' . bin2hex(random_bytes(4));
?>
<section class="section-image-across-columns<?= $isLastSection ? ' last' : '' ?><?= $maxCols === $columns ? ' full' : '' ?>">
	<div class="inner">
    <?php if($image) : ?>
    <div class="image <?= $fill ?> <?= $position === 'left' ? 'first' : 'second' ?>" style="<?= implode('; ', $imgStyles) ?>">
      <picture>
        <?php if($hasMobileImage) : ?>
          <source media="(min-width: 568px)" srcset="<?= esc_url($image['url']) ?>">
        <?php endif; ?>
        <img src="<?= esc_url($hasMobileImage ? $imageMobile['url'] : $image['url'] ) ?>" alt="<?= esc_attr($image['alt']) ?>" />
      </picture>
    </div>
    <?php endif; ?>
    <div class="text <?= $position !== 'left' ? 'first' : 'second' ?>" style="<?= implode('; ', $txtStyles) ?>">
      <div class="inner">
        <h2 class="title section-title"><?= $title ?></h2>
        <div class="body"><?= $body ?></div>
      </div>
    </div>
	</div>
</section>
