<?php

function c4aa_enqueue_assets() {
	wp_enqueue_style( 'twentynineteen-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'c4aa-style', get_stylesheet_directory_uri() . '/style.css' );
	wp_enqueue_style( 'c4aa-style-settings', get_stylesheet_directory_uri() . '/css/00-settings.css' );
	wp_enqueue_style( 'c4aa-style-elements', get_stylesheet_directory_uri() . '/css/02-elements.css' );
	wp_enqueue_style( 'c4aa-style-generic', get_stylesheet_directory_uri() . '/css/03-generic.css' );
	wp_enqueue_style( 'c4aa-style-blocks', get_stylesheet_directory_uri() . '/css/04-blocks.css' );
	wp_enqueue_style( 'c4aa-style-c4aa-imageFilter', get_stylesheet_directory_uri() . '/css/c4aa-imageFilter.css' );
	wp_enqueue_style( 'c4aa-style-c4aa-titleEffect', get_stylesheet_directory_uri() . '/css/c4aa-titleEffect.css' );
}

add_action( 'wp_enqueue_scripts', 'c4aa_enqueue_assets' );


function c4aa_async_webfontloader_inline_script() {
	$font_css_path = get_stylesheet_directory_uri() . "/fonts/webfonts.css";

	echo "<script>

	WebFontConfig = {
		custom: {
			families: ['ralewayblack', 'ralewaymedium', 'zilla_slab_boldbold'],
			urls: [ '$font_css_path' ]
		}
	};

	(function(d) {
		var wf = d.createElement('script'), s = d.scripts[0];
		wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js';
		wf.async = true;
		s.parentNode.insertBefore(wf, s);
	 })(document);</script>\n";
}
add_action( 'wp_head', 'c4aa_async_webfontloader_inline_script', 0 );

/**
 * Point uploads path to the staging server for local development.
 */

if ( 'development' === WP_ENV ) {

	add_filter('pre_option_upload_url_path', function( $upload_url_path ) {
		return 'http://backtobasics.c4aa.org/wp-content/uploads';
	});
}


/**
 * ACF Body Class Options
 *
 * Add a body_class according to ACF options to 
 * provide hooks for CSS.
 */ 

function c4aa_add_body_class_from_acf_options_on_single_or_page( $classes ) {
	$image_filter = get_field( 'c4aa_image_filter' );
	// $title_effect = get_field( 'c4aa_title_effect' );

	// if ( ! empty( $title_effect ) ) {
	// 	$classes[] = "c4aa-titleEffect($title_effect)";
	// }

	if ( is_single() || is_page() ) {
		if ( ! empty( $image_filter ) ) {
			$classes[] = "c4aa-duotone $image_filter";
		}
	}

	return $classes;
}
add_filter( 'body_class', 'c4aa_add_body_class_from_acf_options_on_single_or_page' );


// Initialize Duotone on all post-thumbnails on archives. The specific color
// scheme is set by filtering the post class below, and overriding the 
// defaults via the cascade.
function c4aa_add_archive_body_class( $classes ) {

	if ( is_archive() || is_search() ) {
		$classes[] = "c4aa-duotone";
	}

	return $classes;
}
add_filter( 'body_class', 'c4aa_add_archive_body_class' );

function c4aa_add_post_class_from_acf_options( $classes ) {

	$image_filter = get_field( 'c4aa_image_filter', get_the_ID() );

	if ( ! empty( $image_filter ) ) {
		$classes[] = $image_filter;
	}

	return $classes;
}
add_filter( 'post_class', 'c4aa_add_post_class_from_acf_options' );


/** 
 * Block Color Palette
 * 
 * Note: the namespace for each color is `caa` instead of `c4aa` because Gutenberg
 * adds a hypen in front of the 4 in CSS classes.
 * 
 * via: https://kinsta.com/blog/twenty-nineteen-theme/#block-color-palettes
 * also added in css
 */
function c4aa_setup_theme_supported_features() {
	add_theme_support( 'editor-color-palette', array(
		array(
			'name' => __( 'C4AA Beige', 'themeLangDomain' ),
			'slug' => 'caa-beige',
			'color' => '#e8e6df',
		),
		array(
			'name' => __( 'C4AA Red', 'themeLangDomain' ),
			'slug' => 'caa-red',
			'color' => '#ef3340',
		),
		array(
			'name' => __( 'C4AA Grey', 'themeLangDomain' ),
			'slug' => 'caa-grey',
			'color' => '#968c83',
		),
		array(
			'name' => __( 'C4AA Yellow', 'themeLangDomain' ),
			'slug' => 'caa-yellow',
			'color' => '#e1cd00',
		),
		array(
			'name' => __( 'C4AA Blue', 'themeLangDomain' ),
			'slug' => 'caa-blue',
			'color' => '#005eb8',
		),
	) 
	); // end add_theme_support
} // end c4aa_setup_theme_supported_features

add_action( 'after_setup_theme', 'c4aa_setup_theme_supported_features', 100 );