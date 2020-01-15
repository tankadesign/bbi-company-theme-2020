<?php
  global $isLastSection;
?>
<section class="section-image-across-columns<?= $isLastSection ? ' last' : '' ?>">
	<div class="inner">
    <?php
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
    <div class="image <?= $fill ?> <?= $position === 'left' ? 'first' : 'second' ?>" style="<?= implode('; ', $imgStyles) ?>">
      <img src="<?= esc_url($image['url']) ?>" />
      <div class="fill" style="background-image: url('<?= esc_url($image['url']) ?>')"></div>
    </div>
    <div class="text <?= $position !== 'left' ? 'first' : 'second' ?>" style="<?= implode('; ', $txtStyles) ?>">
      <div class="inner">
        <h2 class="title section-title"><?= $title ?></h2>
        <div class="body"><?= $body ?></div>
      </div>
    </div>
	</div>
</section>
