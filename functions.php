<?php
if( !defined('POWERPRESS_NO_REMOVE_WP_HEAD') ) {
	define( 'POWERPRESS_NO_REMOVE_WP_HEAD', true );
}

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
	wp_enqueue_script( 'c4aa-js-mobileMenu', get_stylesheet_directory_uri() . '/js/mobileMenu.js', [], $script_version, true );
	wp_enqueue_script( 'c4aa-js-scrolling', get_stylesheet_directory_uri() . '/js/scrolling.js', [], $script_version, true );
	wp_enqueue_script( 'c4aa-js-clipPath', get_stylesheet_directory_uri() . '/js/clipPaths.js', [], $script_version, true );
}

add_action( 'wp_enqueue_scripts', 'c4aa_enqueue_assets' );

/**
 * Gutenberg scripts and styles
 * link https://www.billerickson.net/block-styles-in-gutenberg/
 */

function c4aa_gutenberg_scripts() {
	// wp_enqueue_style( 'c4aa-editorStyles', get_stylesheet_directory_uri() . '/src/css/_c4aa-editorStyles.css' );
	wp_enqueue_style( 'c4aa-imageFilter', get_stylesheet_directory_uri() . '/src/css/_c4aa-imageFilter.css' );
	wp_enqueue_script(
		'be-editor',
		get_stylesheet_directory_uri() . '/js/editor.js',
		array( 'wp-blocks', 'wp-dom' ),
		filemtime( get_stylesheet_directory() . '/js/editor.js' ),
		true
	);
}
add_action( 'enqueue_block_editor_assets', 'c4aa_gutenberg_scripts' );

add_action( 'admin_init', 'wpdocs_add_editor_styles' );
function wpdocs_add_editor_styles() {
  add_theme_support( 'editor-styles' );
  add_editor_style( '/src/css/_c4aa-editorStyles.css' );

}

// function to add bloomerang tracking script:
function c4aa_add_bloomerang_tracking_script() {
	echo '<script src="https://api.bloomerang.co/v1/WebsiteVisit?ApiKey=pub_3cb484db-d146-11ec-b5ee-066e3d38bc77" type="text/javascript"></script>
	';
}
add_action( 'wp_head', 'c4aa_add_bloomerang_tracking_script', 0 );



/**
 * Add link icons.
 *
 * Adds a external-link icon to external links only.
 * Related post: https://jeroensormani.com/adding-a-icon-to-external-links/
 */
function ace_add_external_link_icon(  ) {
	wp_register_script( 'external-link-icon', false );
	wp_enqueue_script( 'external-link-icon' );
	
	wp_add_inline_script( 'external-link-icon', "
		function externalLinkIcon() {
			var icon = '<svg xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" aria-hidden=\"true\" role=\"img\" width=\"1em\" height=\"1em\" preserveAspectRatio=\"xMidYMid meet\" viewBox=\"0 0 20 20\">' +
				'<path d=\"M9 3h8v8l-2-1V6.92l-5.6 5.59l-1.41-1.41L14.08 5H10zm3 12v-3l2-2v7H3V6h8L9 8H5v7h7z\" fill=\"currentColor\"/>' +
				'</svg>';
			// Check if content is available
			if (!document.querySelector('.entry-content')) return;
				var links = document.querySelector('.entry-content').querySelectorAll('a:not(:has(img)):not(.wp-block-social-links):not(.wp-block-social-link-anchor)');
				[...links].forEach(function (link) {
					if (link.host !== window.location.host && !link.href.startsWith('mailto:')) {
						link.innerHTML += ' ' + icon;
					}
			});
		}
		window.addEventListener('load', externalLinkIcon, false);
	" );
}
add_action( 'wp_enqueue_scripts', 'ace_add_external_link_icon' );

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
			</ul>
	'; // end echo
}

/**
 * Theme support.
 *
 */
function c4aa_setup_theme_supported_features() {

	// There is a bug with jetpack responsive videos, and they are
	// already supported in core.
	// @see https://github.com/Automattic/jetpack/issues/17170
	remove_theme_support( 'jetpack-responsive-videos' );

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


/* Register blocks for showing People's info in block editor */

add_action( 'init', 'register_c4aa_org_blocks' );

function register_c4aa_org_blocks() {
    register_block_type( __DIR__ . '/blocks/person-title');
    register_block_type( __DIR__ . '/blocks/person-website' );
    register_block_type( __DIR__ . '/blocks/person-email' );
	register_block_type( __DIR__ . '/blocks/person-main-portrait' );

}

/* Register Block Category */
function example_filter_block_categories_when_post_provided( $block_categories, $editor_context ) {
    if ( ! empty( $editor_context->post ) ) {
        array_push(
            $block_categories,
            array(
                'slug'  => 'people-category',
                'title' => __( 'C4AA People', 'c4aa-org-theme' ),
                'icon'  => 'group'
            )
        );
    }
    return $block_categories;
}
add_filter( 'block_categories_all', 'example_filter_block_categories_when_post_provided', 10, 2 );

