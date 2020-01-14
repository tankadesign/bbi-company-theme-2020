<?php
/**
 * Functions and definitions
 *
 */

/*
 * Let WordPress manage the document title.
 */
add_theme_support( 'title-tag' );

/*
 * Enable support for Post Thumbnails on posts and pages.
 */
add_theme_support( 'post-thumbnails' );

/*
 * Switch default core markup for search form, comment form, and comments
 * to output valid HTML5.
 */
add_theme_support( 'html5', array(
	'search-form',
	'gallery',
	'caption',
) );

/** 
 * Include primary navigation menu
 */
function bbi2020_nav_init() {
	global $pagenow;
	
	register_nav_menus( array(
		'menu-1' => 'Main Menu',
	) );
	
	if ($pagenow === 'edit-comments.php') {
		wp_redirect(admin_url());
		exit;
	}
	// Remove comments metabox from dashboard
	//remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
	// Disable support for comments and trackbacks in post types
	foreach (get_post_types() as $post_type) {
		if (post_type_supports($post_type, 'comments')) {
			remove_post_type_support($post_type, 'comments');
			remove_post_type_support($post_type, 'trackbacks');
		}
	}
	// Remove comments links from admin bar
	if (is_admin_bar_showing()) {
		remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
	}
}
add_action( 'init', 'bbi2020_nav_init' );


// Close comments on the front-end
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);

// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);

// Remove comments page in menu
add_action('admin_menu', function () {
	remove_menu_page('edit-comments.php');
});

/**
 * Enqueue scripts and styles.
 */
function bbi2020_scripts() {
	wp_enqueue_style( 'bbi2020-normalize', get_template_directory_uri() . '/assets/css/normalize.css' );
	wp_enqueue_style( 'bbi2020-fonts', get_template_directory_uri() . '/assets/css/fonts.css' );
	wp_enqueue_style( 'bbi2020-style', get_stylesheet_uri() );
	wp_enqueue_style( 'bbi2020-custom-style', get_template_directory_uri() . '/assets/css/style.css' );
	wp_enqueue_script( 'bbi2020-scripts', get_template_directory_uri() . '/assets/js/scripts.js' );
}
add_action( 'wp_enqueue_scripts', 'bbi2020_scripts' );
