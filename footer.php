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
  <div class="nav">
    <div class="inner">
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
        <a href="https://www.linkedin.com/company/beauty-by-imagination-bbi" target="_blank" rel="noopener" class="linkedin"><span class="icon"></span></a>
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