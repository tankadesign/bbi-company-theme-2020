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

function bbi2020_customize_register( $wp_customize ) {
	$wp_customize->add_section('theme_settings', [
		'title'			=> 'Global settings',
		'priority'	=> 1
	]);
	$wp_customize->add_setting( 'site-max-width' , [
		'default'   => '1280px',
    'transport' => 'refresh',
	]);
	$wp_customize->add_control( 'site_max_width', [
		'settings' 	=> 'site-max-width',
		'section' 	=> 'theme_settings',
		'label'			=> 'Site max width',
		'type'			=> 'select',
		'choices'		=> [
			'none' => 'None',
			'960px' => '960px',
			'1120px' => '1120px',
			'1280px' => '1280px',
			'1440px' => '1440px',
			'1600px' => '1600px',
		]
	]);
}
add_action( 'customize_register', 'bbi2020_customize_register' );

// Close comments on the front-end
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);

// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);

// Remove comments page in menu
add_action('admin_menu', function () {
	remove_menu_page('edit-comments.php');
});

// remove WP generator tag
remove_action('wp_head', 'wp_generator');

/**
 * Enqueue scripts and styles.
 */
function bbi2020_add_scripts() {
	$css = file(get_template_directory() . '/style.css', FILE_IGNORE_NEW_LINES);
	$version = '0.1.0';
	foreach($css as $line) :
		if(strpos($line, 'Version: ') === 0) {
			$version = trim(str_replace('Version: ', '', $line));
			break;
		}
	endforeach;

	wp_enqueue_style( 'bbi2020-normalize', get_template_directory_uri() . '/assets/css/normalize.css', [], $version );
	wp_enqueue_style( 'bbi2020-fonts', get_template_directory_uri() . '/assets/css/fonts.css', [], $version );
	wp_enqueue_style( 'bbi2020-style', get_stylesheet_uri(), ['bbi2020-fonts', 'bbi2020-normalize'], $version );
	wp_enqueue_style( 'bbi2020-custom-style', get_template_directory_uri() . '/assets/css/style.css', ['bbi2020-fonts', 'bbi2020-normalize'], $version );
	wp_enqueue_script( 'bbi2020-anime', get_template_directory_uri() . '/assets/js/anime.min.js', [], $version );
	wp_enqueue_script( 'bbi2020-scripts', get_template_directory_uri() . '/assets/js/scripts.js', ['bbi2020-anime'], $version );

}
function bbi2020_remove_scripts () {
	wp_dequeue_style ('wp-block-library-theme');
	wp_dequeue_style ('wp-block-library');
}
add_action( 'wp_enqueue_scripts', 'bbi2020_add_scripts' );
add_action( 'wp_enqueue_scripts', 'bbi2020_remove_scripts', 1000 );


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

function bbi2020_get_article_types () {
	$terms = get_terms([
		'taxonomy' => 'kind',
		'hide_empty' => false
	]);
	$data = [];
	foreach($terms as $term) :
		$data[] = ['id' => $term->ID, 'name' => $term->name];
	endforeach;
	return $data;
}

function bbi2020_get_article_brands () {
	$terms = get_terms([
		'taxonomy' => 'brand',
		'hide_empty' => false
	]);
	$data = [];
	foreach($terms as $term) :
		$data[] = ['id' => $term->ID, 'name' => $term->name];
	endforeach;
	return $data;
}

function bbi2020_get_articles ($last = -1) {
	$posts = get_posts([
		'post_type' => 'article',
		'numberposts' => $last
	]);
	$data = [];
	foreach($posts as $post) :
		$id = $post->ID;
		$format = get_field('article-format', $id);
		$brands = get_field('article-brands', $id);
		if($brands && count($brands)) :
			$brands = array_map(function ($term) {
				return ['id' => $term->ID, 'name' => $term->name];
			});
		endif;
		$types = get_field('article-type', $id);
		if($types && count($types)) :
			$types = array_map(function ($term) {
				return ['id' => $term->ID, 'name' => $term->name];
			});
		endif;
		$urlField = $format == 'pdf' ? 'pdf' : 'url';
		$image = get_field('image', $id);
		$data[] = [
			'id' => $id,
			'title' => $post->post_title,
			'date' => get_field('publication-date', $id),
			'publication' => get_field('publication-name', $id),
			'description' => get_field('description', $id),
			'image' => $image ? $image['url'] : '',
			'url' => get_field($urlField, $id),
			'format' => $format,
			'types' => $types,
			'brands' => $brands,
			'featured' => get_field('is_featured', $id),
		];
	endforeach;
	return $data;
}