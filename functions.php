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
	register_nav_menus( array(
		'menu-1' => 'Main Menu',
	) );
}
add_action( 'init', 'bbi2020_nav_init' );

/**
 * Enqueue scripts and styles.
 */
function bbi2020_scripts() {
	wp_enqueue_style( 'bbi2020-style', get_stylesheet_uri() );
	wp_enqueue_style( 'bbi2020-custom-style', get_template_directory_uri() . '/assets/css/style.css' );
	wp_enqueue_script( 'bbi2020-scripts', get_template_directory_uri() . '/assets/js/scripts.js' );
}
add_action( 'wp_enqueue_scripts', 'bbi2020_scripts' );
