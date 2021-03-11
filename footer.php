<?php
/**
 * The template for displaying the footer
 *
 */

?>

</div>

<footer class="site-footer">
  <div class="logo-strip">
    <div class="inner">
      <?php
        $footer_logos = ['ouidad', 'bioionic', 'wetbrush', 'goody', 'epic-pro', 'solano', 'twist', 'ace'];
        foreach ($footer_logos as $id) {
          include('assets/svg/' . $id . '-logo.svg');
        }
      ?>
    </div> 
  </div>
  <?php
    $footer = get_theme_mod('footer');
    $case = $footer['case'];
  ?>
  <div class="company-info<?= $footer['case'] ? ' use-uppercase' : '' ?>">
    <div class="inner">
      <?php if(!empty($footer['title'])) : ?>
        <div class="title"><?= trim($footer['title']) ?></div>
      <?php endif; ?>
      <?php
        if(!empty($footer['address'])) :
          $mapLink = 'https://www.google.com/maps/search/?api=1&query=' . trim($footer['address']);
          $mapLink = preg_replace('/\s+/', '+', $mapLink);
          $mapLink = preg_replace('/\|/', ',', $mapLink);  
      ?>
        <a href="<?= $mapLink ?>" target="_blank" rel="noopener" class="address"><?= trim($footer['address']) ?></a>
      <?php endif; ?>
      <?php if(!empty($footer['phone'])) : ?>
      <a href="tel:<?= preg_replace('/(.*?)(\d+)\D+(\d+)\D+(\d+)(.*)/', '$1-$2-$3', trim($footer['phone'])) ?>" rel="noopener" class="phone"><?= trim($footer['phone']) ?></a>
      <?php endif; ?>
      <?php if(!empty($footer['email'])) : ?>
      <a href="mailto:<?= strtolower(trim($footer['email'])) ?>" rel="noopener" class="email"><?= trim($footer['email']) ?></a>
      <?php endif; ?>
      <?php if(!empty($footer['linkedin'])) : ?>
      <a href="<?= trim($footer['linkedin']) ?>" target="_blank" rel="noopener" class="linkedin"><span class="icon"></span></a>
      <?php endif; ?>

      <nav>
        <?php
        wp_nav_menu([
          'theme_location' => 'footer-menu',
          'menu_id'        => 'footer-nav',
          'fallback_cb'    => false
        ]);
        ?>
      </nav>
    </div>
  </div>
  <div class="copyright">
      &copy; <span class="year"><?= date('Y') ?></span> Beauty by Imagination.
  </div>
</footer>

<?php
if(is_front_page()) :
  while(have_rows('popup')) : the_row();
    $enabled = get_sub_field('enabled');
    $image = get_sub_field('image');
    $content = get_sub_field('content');
    $identifier = get_sub_field('identifier');
    if(empty($identifier)) $identifier = 'default';
    $hasImage = !empty($image['url']);
    if($enabled) :
?>
<div class="popup" data-identifier="<?= $identifier ?>">
  <div class="panel<?= $hasImage ? ' with-image' : '' ?>">
    <button class="close-btn" type="button">
      <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g fill="white">
          <rect y="1.14294" width="1.61623" height="21.011" transform="rotate(-45 0 1.14294)"/>
          <rect x="1.14282" y="15.9999" width="1.61623" height="21.011" transform="rotate(-135 1.14282 15.9999)"/>
        </g>
      </svg>
    </button>
    <div class="content">
    <?php if($hasImage) : ?>
      <div class="image"><img src="<?= esc_url($image['url']) ?>" alt="<?= esc_attr($image['alt']) ?>" /></div>
    <?php endif; ?>
      <div class="text"><?= $content ?></div>
    </div>
  </div>
  <div class="cover"></div>
</div>
<?php
    endif;
  endwhile;
endif;
wp_footer();
?>

</body>
</html>