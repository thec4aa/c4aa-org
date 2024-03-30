<?php

/* remove  parent script that inserts ellipsis icon on mobile */
function dequeue_priority_menu() {
	wp_dequeue_script( 'twentynineteen-priority-menu' );
}
add_action( 'wp_enqueue_scripts', 'dequeue_priority_menu', 100 );

function c4aa_enqueue_assets() {
	$style_path    = get_stylesheet_directory() . '/build/main.css';
	$style_version = filemtime( $style_path );

	$script_path    = get_stylesheet_directory() . '/js/clipPaths.js';
	$script_version = filemtime( $script_path );

	wp_enqueue_style( 'twentynineteen-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'c4aa-style', get_stylesheet_directory_uri() . '/build/main.css', [], $style_version );
	wp_enqueue_script( 'c4aa-js-clipPath', get_stylesheet_directory_uri() . '/js/clipPaths.js', [], $script_version, true );
}

add_action( 'wp_enqueue_scripts', 'c4aa_enqueue_assets' );

/**
 * Gutenberg scripts and styles
 * link https://www.billerickson.net/block-styles-in-gutenberg/
 */

function c4aa_gutenberg_scripts() {
	wp_enqueue_style( 'c4aa-editorStyles', get_stylesheet_directory_uri() . '/css/c4aa-editorStyles.css' );
	wp_enqueue_style( 'c4aa-imageFilter', get_stylesheet_directory_uri() . '/css/c4aa-imageFilter.css' );
	wp_enqueue_script(
		'be-editor',
		get_stylesheet_directory_uri() . '/js/editor.js',
		array( 'wp-blocks', 'wp-dom' ),
		filemtime( get_stylesheet_directory() . '/js/editor.js' ),
		true
	);
}
add_action( 'enqueue_block_editor_assets', 'c4aa_gutenberg_scripts' );

function c4aa_preload_tags() {
	$fonts_path = get_stylesheet_directory_uri() . "/fonts/";
	$fonts = [
		'metropolis-regular',
		'metropolis-regularitalic',
		'metropolis-semibold',
		'metropolis-semibolditalic',
		'metropolis-extrabold',
		'metropolis-extrabolditalic',
		'RobotoSlab-Bold',
		'RobotoSlab-Regular',
		'RobotoSlab-Light',
	];
	$preload_str = '';

	foreach ( $fonts as $font ) {
		$preload_str .= "<link rel='preload' href='" . $fonts_path . $font . "-webfont.woff2' as='font'>\n";
	}

	echo $preload_str;
}
add_action( 'wp_head', 'c4aa_preload_tags', 0 );

function c4aa_webfontloader_inline_script() {
	$font_css_path = get_stylesheet_directory_uri() . "/fonts/webfonts.css";

	echo "<script>

	WebFontConfig = {
		custom: {
			families: ['metropolis', 'roboto'],
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
add_action( 'wp_head', 'c4aa_webfontloader_inline_script', 0 );

/**
 * ACF Body Class Options
 *
 * Add a body_class according to ACF options to
 * provide hooks for CSS.
 */

function c4aa_add_body_class_from_acf_options_on_single_or_page( $classes ) {
	$image_filter = get_field( 'c4aa_image_filter' );
	$title_effect = get_field( 'c4aa_title_effect' );

	if ( is_single() || is_page() ) {
		if ( ! empty( $image_filter ) ) {
			$classes[] = "$image_filter";
		}

		if ( ! empty( $title_effect ) ) {
			$classes[] = "$title_effect";
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
		$classes[] = "c4aa-excerpt-grid";
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
 * Add Dashboard Widget
 *
 * A place for specific reference info & instructions about the theme
 * for users of the site.
 */

function c4aa_custom_dashboard_widgets() {
	global $wp_meta_boxes;

	wp_add_dashboard_widget('custom_help_widget', 'C4AA Theme Notes', 'c4aa_custom_dashboard_help');
}
add_action('wp_dashboard_setup', 'c4aa_custom_dashboard_widgets');


function c4aa_custom_dashboard_help() {
	echo '
		<h3 id="welcometothenewc4aatheme">Welcome to the new Center for Artistic Activism theme!</h3>
		<p>The new theme uses Gutenberg Blocks. <a href="https://wordpress.org/gutenberg/">Get an introduction and experiment with it here.</a></p>
		<p><strong>Good ideas:</strong></p>
		<ul>
			<li>➡ upload images at 1400px wide where possible</li>
			<li>➡ use colors from the color picker</li>
			<li>➡ If you have questions, ask Steve Lambert.</li>
		</ul>

		<p><strong>Advanced Settings:</strong></p>
			<ul>
				<li><code>no-hyphens</code> will turn off auto-hyphenating on everything in the block.</li>
				<li><code>c4aa-duotone</code> plus one of the following will enable duotone effects on images.
					<ul>
						<li>- <code>red-and-black</code> </li>
						<li>- <code>beige-and-black</code> </li>
						<li>- <code>beige-and-red</code> </li>
						<li>- <code>beige-and-grey</code> </li>
						<li>- <code>beige-and-grey-vintage</code> </li>
						<li>- <code>beige-and-blue</code> </li>
					</ul>
					</li>
			</ul>
	'; // end echo
}

/**
 * Theme support.
 * 
 * Specify block color palette and adjust support for other
 * features as needed.
 */
function c4aa_setup_theme_supported_features() {
	
	// There is a bug with jetpack responsive videos, and they are
	// already supported in core.
	// @see https://github.com/Automattic/jetpack/issues/17170
	remove_theme_support( 'jetpack-responsive-videos' ); 
	
	// Note: the namespace for each color is `caa` instead of `c4aa` because Gutenberg
	// adds a hypen in front of the 4 in CSS classes.
	// @see https://kinsta.com/blog/twenty-nineteen-theme/#block-color-palettes
	// also added in css
	add_theme_support( 'editor-color-palette', array(
		array(
			'name' => __( 'C4AA Beige', 'c4aa' ),
			'slug' => 'caa-beige',
			'color' => '#e8e6df',
		),
		array(
			'name' => __( 'C4AA Red', 'c4aa' ),
			'slug' => 'caa-red',
			'color' => '#ef3340',
		),
		array(
			'name' => __( 'C4AA Grey', 'c4aa' ),
			'slug' => 'caa-grey',
			'color' => '#968c83',
		),
		array(
			'name' => __( 'C4AA Black', 'c4aa' ),
			'slug' => 'caa-black',
			'color' => '#000000',
		),
		array(
			'name' => __( 'C4AA Yellow', 'c4aa' ),
			'slug' => 'caa-yellow',
			'color' => '#e1cd00',
		),
		array(
			'name' => __( 'C4AA Blue', 'c4aa' ),
			'slug' => 'caa-blue',
			'color' => '#005eb8',
		),
		array(
			'name' => __( 'C4AA White', 'c4aa' ),
			'slug' => 'caa-white',
			'color' => '#fafaf9',
		),
	)
	); // end add_theme_support
} // end c4aa_setup_theme_supported_features

add_action( 'after_setup_theme', 'c4aa_setup_theme_supported_features', 11 );

/**
 * Override default 2019 post thumbnail.
 * Only change is adding the class for the image
 * filter CSS algorithm, a-filter-child-img
 */
function twentynineteen_post_thumbnail() {
	if ( ! twentynineteen_can_show_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) :
		?>

		<figure class="post-thumbnail a-filter-child-img">
			<?php the_post_thumbnail(); ?>
		</figure><!-- .post-thumbnail -->

		<?php
	else :
		?>

	<figure class="post-thumbnail a-filter-child-img">
		<a class="post-thumbnail-inner" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php the_post_thumbnail( 'post-thumbnail' ); ?>
		</a>
	</figure>

		<?php
	endif; // End is_singular().
}
