<section class="locations">
	<div class="inner">
    <?php
      if(have_rows('location-items')) :
        $sectionTitle = get_sub_field('section-title');
    ?>
      <div class="locations">
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
          <h3 class="title"><?= $title ?></h3>
          <p class="description"><?= $description ?></p>
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
