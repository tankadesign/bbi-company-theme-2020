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
        $footer_logos = ['ouidad', 'bioionic', 'wetbrush', 'goody', 'epic-pro', 'solano', 'ace'];
        foreach ($footer_logos as $id) {
          include('assets/svg/' . $id . '-logo.svg');
        }
      ?>
    </div> 
  </div>
  <div class="company-info">
    <div class="inner">
      <?php /*
      <div class="site-logo">
        <a href="<?php print site_url() ?>">
          <?php include('assets/svg/bbi-logo.svg') ?>
        </a>
      </div>
      <nav class="main-navigation">
        <?php
        wp_nav_menu( array(
          'theme_location' => 'menu-1',
          'menu_id'        => 'primary-menu',
        ) );
        ?>
      </nav>
      */ ?>

      <?php
        $footer = get_theme_mod('footer');
        if(empty($footer['phone'])) $footer['phone'] = '800.523.2889';
        if(empty($footer['email'])) $footer['email'] = 'web@bbicompany.com';
        if(empty($footer['linkedin'])) $footer['linkedin'] = 'https://www.linkedin.com/company/beauty-by-imagination-bbi';
        if(empty($footer['address'])) $footer['address'] = '102 Madison Ave | 3rd Floor | New York NY 10016';
        $mapLink = 'https://www.google.com/maps/search/?api=1&query=' . trim($footer['address']);
        $mapLink = preg_replace('/\s+/', '+', $mapLink);
        $mapLink = preg_replace('/\|/', ',', $mapLink);
      ?>
        <a href="<?= $mapLink ?>" target="_blank" rel="noopener" class="address"><?= $footer['address'] ?></a>
        <a href="tel:<?= preg_replace('/(.*?)(\d+)\D+(\d+)\D+(\d+)(.*)/', '$1-$2-$3', $footer['phone']) ?>" rel="noopener" class="phone"><?= $footer['phone'] ?></a>
        <a href="mailto:<?= $footer['email'] ?>" rel="noopener" class="email"><?= $footer['email'] ?></a>
        <a href="<?= $footer['linkedin'] ?>" target="_blank" rel="noopener" class="linkedin"><span class="icon"></span></a>
      <?php
      ?>
    </div>
  </div>
  <div class="copyright">
      &copy; <span class="year"><?= date('Y') ?></span> Beauty by Imagination.
  </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>