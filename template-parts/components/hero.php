<?php
  if(have_rows('hero')) :
    while(have_rows('hero')) : the_row();

      $imageDesktop = get_sub_field('desktop_image');
      $imageMobile = get_sub_field('mobile_image');
      $title = get_sub_field('title');
      $body = get_sub_field('body');
      $desktopStyle = get_sub_field('text_style_desktop');
      $mobileStyle = get_sub_field('text_style_mobile');
      $desktopStyleColor = strpos($desktopStyle, 'white') === 0 ? 'white' : 'black';
      $mobileStyleColor = strpos($mobileStyle, 'white') === 0 ? 'white' : 'black';
      $desktopFadeColor = get_sub_field('fade_color_desktop');
      $mobileFadeColor = get_sub_field('fade_color_mobile');
      $desktopScalePoint = get_sub_field('scale_point_desktop');
      $mobileScalePoint = get_sub_field('scale_point_mobile');
      $mobileFadeRGB = '';
      $desktopFadeRGB = '';
      if($desktopFadeColor) {
        list($r, $g, $b) = sscanf($desktopFadeColor, "#%02x%02x%02x");
        $desktopFadeRGB = "$r,$g,$b";
      } else {
        $desktopFadeRGB = $desktopStyleColor == 'white' ? '0,0,0' : '255,255,255';
      }
      if($mobileFadeColor) {
        list($r, $g, $b) = sscanf($mobileFadeColor, "#%02x%02x%02x");
        $mobileFadeRGB = "$r,$g,$b";
      } else {
        $mobileFadeRGB = $mobileStyleColor == 'white' ? '0,0,0' : '255,255,255';
      }
      $rand = bin2hex(random_bytes(4));
      $id = 'hero-' . $rand;
    ?>
    <div class="hero" id="<?= $id ?>">
      <div class="image"></div>
      <div class="fade"></div>
      <div class="text">
        <div class="inner">
          <h1 class="title"><?= $title ?></h1>
          <div class="body"><?= $body ?></div>
        </div>
      </div>
    </div>
    <style type="text/css">
      <?= '#' . $id ?> .image {
        background-image: url('<?= $imageMobile['url'] ?>');
        background-position: <?= $mobileScalePoint ?>;
      }
      <?= '#' . $id ?> .text {
        color: <?= $mobileStyleColor ?>;
      }
      <?= '#' . $id ?> .fade {
        background: linear-gradient(to bottom, rgba(<?= $mobileFadeRGB ?>, 0), rgba(<?= $mobileFadeRGB ?>, 0.75));
        display: <?= strpos($mobileStyle, 'overlay') ? 'block' : 'none' ?>;
      }
      @media (min-width: 568px) {
        <?= '#' . $id ?> .image {
          background-image: url('<?= $imageDesktop['url'] ?>');
          background-position: <?= $desktopScalePoint ?>;
        }
        <?= '#' . $id ?> .text {
          color: <?= $desktopStyleColor ?>;
        }
        <?= '#' . $id ?> .fade {
          background: linear-gradient(to bottom left, rgba(<?= $desktopFadeRGB ?>, 0) 40%, rgba(<?= $desktopFadeRGB ?>, 0.95));
          display: <?= strpos($desktopStyle, 'overlay') ? 'block' : 'none' ?>;
        }
      }
    </style>
    <?php
    endwhile;
  endif;
?>