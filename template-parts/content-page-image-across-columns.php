<?php
  global $isLastSection;
  $image = get_sub_field('image');
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
  $imgStyles[] = 'flex: ' . $columns;
  $txtStyles[] = 'flex: ' . ($maxCols - $columns);
  $imgStyles[] = 'order: ' . ($position === 'left' ? 1 : 2);
  $txtStyles[] = 'order: '. ($position === 'left' ? 2 : 1);
  $txtStyles[] = 'display: flex; align-items: ' . $valign;
?>
<section class="section-image-across-columns<?= $isLastSection ? ' last' : '' ?><?= $maxCols === $columns ? ' full' : '' ?>">
	<div class="inner">
    <?php if($image) : ?>
    <div class="image <?= $fill ?> <?= $position === 'left' ? 'first' : 'second' ?>" style="<?= implode('; ', $imgStyles) ?>">
      <img src="<?= esc_url($image['url']) ?>" alt="<?= esc_attr($image['alt']) ?>" />
      <div class="fill" style="background-image: url('<?= esc_url($image['url']) ?>')"></div>
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
