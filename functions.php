<?php

function c4aa_enqueue_assets() {
	wp_enqueue_style( 'twentynineteen-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'c4aa-style', get_stylesheet_directory_uri() . '/style.css' );
	wp_enqueue_style( 'c4aa-style-settings', get_stylesheet_directory_uri() . '/css/00-settings.css' );
	wp_enqueue_style( 'c4aa-style-elements', get_stylesheet_directory_uri() . '/css/02-elements.css' );
	wp_enqueue_style( 'c4aa-style-generic', get_stylesheet_directory_uri() . '/css/03-generic.css' );
	wp_enqueue_style( 'c4aa-style-objects', get_stylesheet_directory_uri() . '/css/04-objects.css' );
	wp_enqueue_style( 'c4aa-style-algorithms', get_stylesheet_directory_uri() . '/css/05-algorithms.css' );
	wp_enqueue_style( 'c4aa-style-utilities', get_stylesheet_directory_uri() . '/css/06-utilities.css' );
}

add_action( 'wp_enqueue_scripts', 'c4aa_enqueue_assets' );

if ( 'development' === WP_ENV ) {

	add_filter('pre_option_upload_url_path', function ($upload_url_path) {
		return 'http://backtobasics.c4aa.org/wp-content/uploads';
	});
}

