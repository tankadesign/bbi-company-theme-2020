<?php
/**
 * Template name: Page with sections
 * The template for displaying all pages
 *
 */

get_header();
?>

<main id="main" class="site-main" role="main">

	<?php
	while ( have_posts() ) : the_post();

		get_template_part( 'template-parts/content', 'page-sections' );

	endwhile; 
	?>

</main>

<?php
get_footer();