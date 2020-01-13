<?php
  global $postCount;
  global $maxPosts;

  if( have_rows('sections') ):
    while ( have_rows('sections') ) : the_row();
      $enabled = get_sub_field('section-enabled');
      if($enabled) $maxPosts++;
    endwhile;
    while ( have_rows('sections') ) : the_row();
      $enabled = get_sub_field('section-enabled');
      if(!$enabled) continue;
      $layout = get_row_layout();
      get_template_part( 'template-parts/content', 'page-' . $layout );
      $postCount++;
    endwhile;
  endif;

?>