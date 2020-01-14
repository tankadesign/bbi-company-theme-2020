<?php
/**
 * The header for the theme
 *
 */

	$hasHero = get_field('has_hero', $post->ID);
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php wp_head(); ?>
</head>

<body <?php body_class( $hasHero ? 'has-hero' : '' ); ?>>
	
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
	
