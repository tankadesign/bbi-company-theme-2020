<?php
  global $isLastSection;
  $sectionTitle = get_sub_field('section-title');
  $sectionBody = get_sub_field('section-body');
  $maxColumns = get_sub_field('max-columns');
  $valign = get_sub_field('valign');
?>
<section class="section-plain-text section-with-title-body<?= $isLastSection ? ' last' : '' ?> max-cols<?= $maxColumns ?> valign-<?= $valign ?>">
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
</section>
