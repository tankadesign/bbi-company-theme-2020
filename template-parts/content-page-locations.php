<?php
  global $isLastSection;
  $sectionTitle = trim(get_sub_field('section-title'));
  $sectionBody = trim(get_sub_field('section-body'));
  $maxColumns = trim(get_sub_field('max-columns'));
  if(!$maxColumns) $maxColumns = 4;
  $items = get_sub_field('location-items');
  $hasTitle = !empty($sectionTitle);
  $hasBody = !empty($sectionBody);
?>
<section class="section-locations<?= $isLastSection ? ' last' : '' ?><?= $hasBody ? ' section-with-title-body' : '' ?><?= !$hasBody && $hasTitle ? ' title-only' : '' ?>">
  <?php if($hasBody) : ?>
  <div class="title-body">
    <div class="title">
      <div class="inner">
        <h2 class="section-title"><?= $sectionTitle ?></h2>
      </div>
    </div>
    <div class="body">
      <div class="inner">
        <?= $sectionBody ?>
      </div>
    </div>
  </div>
  <?php endif; ?>
	<div class="inner">
    <?php
      if(have_rows('location-items')) :
    ?>
      <div class="locations max-cols<?= $maxColumns ?>" data-count="<?= count($items) ?>">
        <?php
          $i = 0;
          while(have_rows('location-items')) : the_row();
            $title = trim(get_sub_field('location-title'));
            $description = trim(get_sub_field('location-description'));
            $image = get_sub_field('image');
            $linkUrl = get_sub_field('url');
            $imageUrl = esc_url($maxColumns >= 3 ? $image['sizes']['article-thumb'] : $image['url']);
            $i++;
        ?>
        <div class="location">
        <?php if($i===1 && !$hasBody) : ?>
          <h2 class="section-title"><?= $sectionTitle ?></h2>
        <?php endif;?>
          <div class="image">
            <img src="<?= $imageUrl ?>" alt="<?= esc_attr($image['alt']) ?>" />
          </div>
          <div class="text">
            <h3 class="title"><?= $title ?></h3>
            <?php if(!empty($description)) : ?>
              <div class="description"><?= $description ?></div>
            <?php endif; ?>
            <?php if(!empty($linkUrl)) : ?>
              <div class="link">
                <a class="more-btn" href="<?= esc_url($linkUrl) ?>" target="_blank" rel="noopener">View site</a>
              </div>
            <?php endif; ?>
          </div>
        </div>
        <?php
          endwhile;
        ?>
      </div>
    <?php
      endif;
    ?>
	</div>
</section>
