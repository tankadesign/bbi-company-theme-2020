<?php
  global $isLastSection;
?>
<section class="section-locations<?= $isLastSection ? ' last' : '' ?>">
	<div class="inner">
    <?php
      $sectionTitle = get_sub_field('section-title');
      $items = get_sub_field('location-items');
      if(have_rows('location-items')) :
    ?>
      <div class="locations" data-count="<?= count($items) ?>">
        <?php
          $i = 0;
          while(have_rows('location-items')) : the_row();
            $title = trim(get_sub_field('location-title'));
            $description = trim(get_sub_field('location-description'));
            $image = get_sub_field('image');
            $i++;
        ?>
        <div class="location">
        <?php if($i===1) : ?>
          <h2 class="section-title"><?= $sectionTitle ?></h2>
        <?php endif;?>
          <div class="image" style="background-image: url('<?= $image['url'] ?>')"></div>
          <div class="text">
            <h3 class="title"><?= $title ?></h3>
            <p class="description"><?= $description ?></p>
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
