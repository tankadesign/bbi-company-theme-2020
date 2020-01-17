<?php
/**
 * The header for the theme
 *
 */

	$hasHero = get_field('has_hero', $post->ID);
	$maxWidth = get_theme_mod('site-max-width', '1280px');
	$hasSiteMax = $maxWidth != 'none';
	$classes = [];
	if($hasHero) $classes[] = 'has-hero';
	if($hasSiteMax) {
		$classes[] = 'has-max-width';
		$classes[] = 'site-max-' . $maxWidth;
	}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style type="text/css">
		:root {
			--site-max: <?= $maxWidth ?>;
		}
	</style>
	<?php wp_head(); ?>
</head>

<body <?php body_class( $classes ); ?>>
	
<a class="screen-reader-text" href="#content">Skip to content</a>

<header class="site-header">
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
		</nav>

		<button class="mobile-nav-btn">
			<div class="line line1"></div>
			<div class="line line2"></div>
			<div class="line line3"></div>
		</button>
	</div>
</header>

<?php
	if( $hasHero ) :
		while ( have_posts() ) : the_post();
			get_template_part( 'template-parts/components/hero' );
		endwhile;
	endif;
?>

<div id="content" class="site-content">
	
