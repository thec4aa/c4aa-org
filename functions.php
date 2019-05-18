<?php

function c4aa_enqueue_assets() {
	wp_enqueue_style( 'twentynineteen-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'c4aa-style', get_stylesheet_directory_uri() . '/style.css' );
	wp_enqueue_style( 'c4aa-style-settings', get_stylesheet_directory_uri() . '/css/00-settings.css' );
	wp_enqueue_style( 'c4aa-style-elements', get_stylesheet_directory_uri() . '/css/02-elements.css' );
	wp_enqueue_style( 'c4aa-style-generic', get_stylesheet_directory_uri() . '/css/03-generic.css' );
	wp_enqueue_style( 'c4aa-style-c4aa-imageFilter', get_stylesheet_directory_uri() . '/css/c4aa-imageFilter.css' );
	wp_enqueue_style( 'c4aa-style-c4aa-titleEffect', get_stylesheet_directory_uri() . '/css/c4aa-titleEffect.css' );
}

add_action( 'wp_enqueue_scripts', 'c4aa_enqueue_assets' );

if ( 'development' === WP_ENV ) {

	add_filter('pre_option_upload_url_path', function ($upload_url_path) {
		return 'http://backtobasics.c4aa.org/wp-content/uploads';
	});
}


/**
 * ACF Body Class Options
 *
 * Add a body_class according to ACF options to 
 * provide hooks for CSS.
 */ 

function c4aa_add_body_class_from_acf_options( $classes ) {

	$image_filter = get_field( 'c4aa_image_filter' );
	$title_effect = get_field( 'c4aa_title_effect' );

	if ( ! empty( $title_effect ) ) {
		$classes[] = "c4aa-titleEffect($title_effect)";
	}

	if ( ! empty( $image_filter ) ) {
		$classes[] = "c4aa-imageFilter($image_filter)";
	}

	return $classes;
}
add_filter( 'body_class', 'c4aa_add_body_class_from_acf_options' );