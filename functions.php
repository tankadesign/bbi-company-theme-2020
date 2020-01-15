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


function bbi2020_get_job_departments () {
	return [
		'Creative',
		'Communications',
		'Customer',
		'Finance',
		'Legal',
		'Operations',
		'Marketing',
	];
}

function bbi2020_get_job_locations () {
	return [
		'New York',
		'Long Island',
		'Atlanta',
	];
}

function bbi2020_set_choices ($field, $choices) {
	$field['choices'] = [];
	foreach($choices as $choice) :
		$field['choices'][$choice] = $choice;
	endforeach;
	return $field;
}

function bbi2020_load_department ($field) {
	return bbi2020_set_choices($field, bbi2020_get_job_departments());
}
add_filter('acf/load_field/name=department', 'bbi2020_load_department');

function bbi2020_load_location ($field) {
	return bbi2020_set_choices($field, bbi2020_get_job_locations());
}
add_filter('acf/load_field/name=location', 'bbi2020_load_location');

function bbi2020_get_job_listings () {
	$posts = get_posts([
		'post_type' => 'job',
		'numberposts' => -1
	]);
	$data = [];
	foreach($posts as $post) :
		$dept = get_field('department', $post->ID);
		$data[] = [
			'id' => $post->ID,
			'title' => $post->post_title,
			'date' => $post->post_date,
			'department' => $dept,
			'location' => get_field('location', $post->ID),
			'url' => get_field('url', $post->ID),
		];
	endforeach;
	$byDepartment = [];
	$byLocation = [];
	$departments = bbi2020_get_job_departments();
	$locations = bbi2020_get_job_locations();
	foreach($departments as $dept) :
		$items = array_filter($data, function($item) use($dept) {
			return $item['department'] === $dept;
		});
		$byDepartment[$dept] = $items;
	endforeach;
	foreach($locations as $location) :
		$items = array_filter($data, function($item) use($location) {
			return $item['location'] === $location;
		});
		$byLocation[$location] = $items;
	endforeach;
	return [
		'byDepartment' => $byDepartment,
		'byLocation' => $byLocation,
		'all' => $data
	];
}