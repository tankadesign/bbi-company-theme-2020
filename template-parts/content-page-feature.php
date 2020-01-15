<?php
  global $isLastSection;
?>
<section class="section-feature<?= $isLastSection ? ' last' : '' ?>">
	<div class="inner">
    <?php
      $image = get_sub_field('feature-image');
      $position = get_sub_field('feature-position');
      $title = get_sub_field('feature-title');
      $body = get_sub_field('feature-body');
    ?>
    <div class="image <?= $position === 'left' ? 'first' : 'second' ?>">
      <img src="<?= $image['url'] ?>" />
      <div class="fill" style="background-image: url('<?= $image['url'] ?>')"></div>
    </div>
    <div class="text <?= $position !== 'left' ? 'first' : 'second' ?>" style="<?= implode('; ', $txtStyles) ?>">
      <div class="inner">
        <h2 class="title section-title"><?= $title ?></h2>
        <div class="body"><?= $body ?></div>
      </div>
    </div>
	</div>
</section>
