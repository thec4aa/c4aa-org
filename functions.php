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

add_action('the_content', 'zole_remove_unused_shortcode');

function zole_remove_unused_shortcode($content) { 
	$pattern = '\\b([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*+(?:\\[(?!\\/\\2\\])[^\\[]*+)*+)\\[\\/\\2\\])?)(\\]?)';
	$matches = preg_match_all( '/'. $pattern .'/s', 'strip_shortcode_tag', $content );
	print_r( $matches );
}

function zole_get_unused_shortcode_regex() {
	global $shortcode_tags;
	$tagnames = array_keys($shortcode_tags);
	$tagregexp = join( '|', array_map('preg_quote', $tagnames) );
	$regex = '\\[(\\[?)';
	$regex .= "(?!$tagregexp)";
	$regex .= '\\b([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*+(?:\\[(?!\\/\\2\\])[^\\[]*+)*+)\\[\\/\\2\\])?)(\\]?)';
	return $regex;
}