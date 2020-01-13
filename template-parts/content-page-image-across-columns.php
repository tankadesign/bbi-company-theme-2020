<section class="image-across-columns">
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
      $txtStyles[] = 'flex: ' . $maxCols - $columns;
      $imgStyles[] = 'order: ' . ($position == 'left' ? 1 : 2);
      $txtStyles[] = 'order: '. ($position == 'left' ? 2 : 1);
      $txtStyles[] = 'align-self: ' . $valign;
      $imgStylesBg = 'background: url(\'' . esc_url($image['url']) . '\') center center no-repeat';
      $imgStylesBg .= '; background-size: ' . ($fill === 'contain' ? 'contain' : 'cover');
      if($fill === 'cover' || $fill === 'contain') :
        $imgStyles[] = $imgStylesBg;
      else :
        $imgFillStyles[] = $imgStylesBg;
      endif;
    ?>
    <div class="image <?= $fill ?>" style="<?= implode('; ', $imgStyles) ?>">
      <?php if($fill == 'cover-padded') :?>
        <div class="fill" style="<?= implode('; ', $imgFillStyles) ?>"></div>
      <?php endif; ?>
    </div>
    <div class="text" style="<?= implode('; ', $txtStyles) ?>">
      <h2 class="title"><?= $title ?></h2>
      <div class="body"><?= $body ?></div>
    </div>
	</div>
</section>
