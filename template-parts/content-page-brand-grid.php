<?php
  global $isLastSection;
?>
<section class="section-brands<?= $isLastSection ? ' last' : '' ?>">
  <?php
    $sectionTitle = get_sub_field('section-title');
    $sectionBody = get_sub_field('section-body');
    $brands = get_sub_field('brands');
  ?>
  <div class="intro">
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
  <div class="inner">
    <?php
      if(have_rows('brands')) :
    ?>
      <div class="brands" data-count="<?= count($brands) ?>">
        <?php
          $i = 0;
          while(have_rows('brands')) : the_row();
            $name = trim(get_sub_field('brand-name'));
            $description = trim(get_sub_field('brand-description'));
            $logo = get_sub_field('brand-logo');
            $logoFile = get_template_directory() . '/assets/svg/' . $logo . '-logo.svg';
            $image = get_sub_field('brand-image');
            $i++;
        ?>
        <div class="brand">
          <div class="inner">
            <div class="image" style="background-image: url('<?= $image['url'] ?>')"></div>
            <div class="text">
              <div class="inner">
                <?php
                  if($logo && file_exists($logoFile)) :
                    $svg = file_get_contents($logoFile);
                    $svg = str_replace('<svg ', '<svg preserveAspectRatio="xMinYMid meet" ', $svg);
                ?>
                  <div class="logo"><?= $svg ?></div>
                <?php endif; ?>
                <h3 class="name"><?= $name ?></h3>
                <div class="description"><?= $description ?></div>
              </div>
              <div class="bg"></div>
            </div>
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
