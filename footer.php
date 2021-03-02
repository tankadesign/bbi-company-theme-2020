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

<?php wp_footer(); ?>

</body>
</html>