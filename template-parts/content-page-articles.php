<?php
  global $isLastSection;
  $types = bbi2020_get_article_types();
  array_unshift($types, ['id' => -1, 'name' => 'All']);
  $brands = bbi2020_get_article_brands();
  array_unshift($brands, ['id' => -1, 'name' => 'All']);
  
  $featureLatest = (int) get_sub_field('feature-latest');
  $articlesData = bbi2020_get_articles(-1, $featureLatest);
  $years = array_map(function ($item) {return $item['year'];}, $articlesData['unfeatured']);
  $years = array_unique($years);
  rsort($years);
  array_unshift($years, 'All');

?>
<section class="section-articles<?= $isLastSection ? ' last' : '' ?>">
  <?php if(!count($articlesData['featured']) && !count($articlesData['unfeatured'])) : ?>
    <div class="inner">
      <h2 class="section-title"><?= get_sub_field('featured-title') ?></h2>
    </div>
    <p class="empty">There aren’t any articles at the moment. Please check back later.</p>
  <?php else: ?>
    <?php if(count($articlesData['featured'])) : ?>
    <div class="featured">
      <h2 class="section-title"><?= get_sub_field('featured-title') ?></h2>
      <div class="featured-list articles">
        <?php
          set_query_var('articles', $articlesData['featured']);
          get_template_part( 'template-parts/components/article-preview' );
        ?>
      </div>
    </div>
  <?php endif; ?>
    <div class="inner unfeatured">
      <div class="filter-header">
        <h2 class="section-title"><?= get_sub_field('filter-title') ?></h2>
        <div class="results-notice">
          <div class="zero-results hidden">No articles match those filters</div>
          <div class="total-results">Showing <span class="total"><?= count($articlesData['unfeatured']) ?></span> <span class="things">articles</span></div>
        </div>
      </div>
      <div class="filters">
        <div class="filter types">
          <div class="group-name">Type</div>
          <div class="choices">
            <?php foreach($types as $choice) : ?>
              <div class="choice">
                <label>
                  <input type="checkbox" name="<?= $choice['name'] ?>" data-id="<?= $choice['id'] ?>" data-group="type"<?= $choice['id'] === -1 ? ' checked' : ''?><?= $choice['id'] === -1 || bbi2020_type_has_articles($choice, $articlesData['unfeatured']) ? '' : ' disabled' ?> />
                  <span class="check"><span class="fill"></span></span>
                  <span class="name"><?= $choice['name'] ?></span>
                </label>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
  
        <div class="filter brands">
          <div class="group-name">Brand</div>
          <div class="choices">
            <?php foreach($brands as $choice) : ?>
              <div class="choice">
                <label>
                  <input type="checkbox" name="<?= $choice['name'] ?>" data-id="<?= $choice['id'] ?>" data-group="brand"<?= $choice['id'] === -1 ? ' checked' : ''?><?= $choice['id'] === -1 || bbi2020_brand_has_articles($choice, $articlesData['unfeatured']) ? '' : ' disabled' ?> />
                  <span class="check"><span class="fill"></span></span>
                  <span class="name"><?= $choice['name'] ?></span>
                </label>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
        
        <?php if(count($years) > 2) : ?>
        <div class="filter years">
          <div class="group-name">Date</div>
          <div class="choices">
            <?php foreach($years as $choice) : ?>
              <div class="choice">
                <label>
                  <input type="checkbox" name="<?= $choice ?>" data-id="<?= $choice['id'] ?>" data-group="year"<?= $choice === 'All' ? ' checked' : ''?> />
                  <span class="check"><span class="fill"></span></span>
                  <span class="name"><?= $choice ?></span>
                </label>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>
  
      </div>
    </div>
    <div class="filtered-list articles">
      <?php
        set_query_var('articles', $articlesData['unfeatured']);
        get_template_part( 'template-parts/components/article-preview' );
      ?>
    </div>
  <?php endif; ?>

</section>