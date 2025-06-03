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
    // CSS versioning
    $style_path = get_stylesheet_directory() . '/build/main.css';
    $style_version = file_exists($style_path) ? filemtime($style_path) : '1.0';
    
    // JS versioning - individual for each file
    $js_base_path = get_stylesheet_directory() . '/js/';
    $js_files = ['menu.js', 'scrolling.js', 'assorted.js', 'clipPaths.js'];
    
    // Enqueue CSS
    wp_enqueue_style('twentynineteen-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('c4aa-style', get_stylesheet_directory_uri() . '/build/main.css', [], $style_version);
    
    // Enqueue JS - with individual versioning
    foreach ($js_files as $js_file) {
        $file_path = $js_base_path . $js_file;
        $file_version = file_exists($file_path) ? filemtime($file_path) : '1.0';
        $handle = 'c4aa-js-' . pathinfo($js_file, PATHINFO_FILENAME);
        
        wp_enqueue_script($handle, get_stylesheet_directory_uri() . '/js/' . $js_file, [], $file_version, true);
    }
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

// This filter allows emoji to be added to the post content
// https://stackoverflow.com/questions/63100373/wordpress-unable-to-save-or-update-posts-with-emoji
add_filter( 'wp_insert_post_data', function( $data, $postarr ) {
	if ( ! empty( $data['post_content'] ) ) {
		$data['post_content'] = wp_encode_emoji( $data['post_content'] );
	}
	return $data;
	}, 99, 2 );

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
function ace_add_external_link_icon() {
    wp_register_script('external-link-icon', false);
    wp_enqueue_script('external-link-icon');

    wp_add_inline_script('external-link-icon', "
        function externalLinkIcon() {
            var icon = '<svg xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" aria-hidden=\"true\" role=\"img\" width=\"1em\" height=\"1em\" preserveAspectRatio=\"xMidYMid meet\" viewBox=\"0 0 20 20\">' +
                '<path d=\"M9 3h8v8l-2-1V6.92l-5.6 5.59l-1.41-1.41L14.08 5H10zm3 12v-3l2-2v7H3V6h8L9 8H5v7h7z\" fill=\"currentColor\"/>' +
                '</svg>';
            // Check if content is available
            if (!document.querySelector('.entry-content')) return;
            var links = document.querySelector('.entry-content').querySelectorAll('a');
            [...links].forEach(function(link) {
                if (link.host!== window.location.host 
				&&!link.href.startsWith('mailto:') 
				&&!link.querySelector('img') 
				&&!link.classList.contains('wp-block-social-links') 
				&&!link.classList.contains('wp-block-social-link-anchor') 
				&&!link.closest('.wp-block-jetpack-slideshow')) {
                    link.innerHTML +='' + icon;
                }
            });
        }
        window.addEventListener('load', externalLinkIcon, false);
    ");
}
add_action( 'wp_enqueue_scripts', 'ace_add_external_link_icon' );

// Add Social Link Icons for Bluesky

// Add Bluesky to the social icons map
function add_bluesky_social_icon( $social_icons ) {
    $social_icons['bsky.app'] = 'bluesky';
    return $social_icons;
}
add_filter( 'twentynineteen_social_icons_map', 'add_bluesky_social_icon' );

// Add the actual SVG content for Bluesky
function add_bluesky_svg_icon( $social_icons ) {
    $social_icons['bluesky'] = '
<svg viewBox="0 0 600 530" version="1.1" xmlns="http://www.w3.org/2000/svg">
    <path d="m135.72 44.03c66.496 49.921 138.02 151.14 164.28 205.46 26.262-54.316 97.782-155.54 164.28-205.46 47.98-36.021 125.72-63.892 125.72 24.795 0 17.712-10.155 148.79-16.111 170.07-20.703 73.984-96.144 92.854-163.25 81.433 117.3 19.964 147.14 86.092 82.697 152.22-122.39 125.59-175.91-31.511-189.63-71.766-2.514-7.3797-3.6904-10.832-3.7077-7.8964-0.0174-2.9357-1.1937 0.51669-3.7077 7.8964-13.714 40.255-67.233 197.36-189.63 71.766-64.444-66.128-34.605-132.26 82.697-152.22-67.108 11.421-142.55-7.4491-163.25-81.433-5.9562-21.282-16.111-152.36-16.111-170.07 0-88.687 77.742-60.816 125.72-24.795z" />
</svg>';
    
    return $social_icons;
}
add_filter( 'twentynineteen_social_icons', 'add_bluesky_svg_icon' );
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

// Adds a search form to the search results page.
// so if you search for something and don't find it, you can search again!

/**
 * Setup a custom hook before the second post on the search page
 */
add_action( 'the_post', function( $post, \WP_Query $q )
{
    if( $q->is_search() && $q->is_main_query() && 0 === $q->current_post )
    {
        do_action( 'wpse_before_second_post_in_search' );
    }
}, 10, 2 ); 

/**
 * Inject a Div after the first post on the search page
 */
add_action( 'wpse_before_second_post_in_search', function()
{
	echo '<article class="entry search-results-search-form
	"><div class="entry-content"><div class="wp-block-group"><div class="wp-block-group__inner-container search-form-in-results">';
	echo get_search_form( array('label' => 'Didn\'t find what you\'re looking for?', 'placeholder' => 'Search again...') );
	echo '</div></div></div></article>';
} );

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
 * Filter to disable post thumbnail display for 'people' custom post type.
 *
 * @param bool $can_show Whether the post thumbnail can be displayed.
 * @return bool Modified value for post thumbnail display.
 */
function my_child_theme_disable_people_post_thumbnail( $can_show ) {
    if ( is_singular( 'people' ) ) {	
        return false;
    }
    return $can_show;
}
add_filter( 'twentynineteen_can_show_post_thumbnail', 'my_child_theme_disable_people_post_thumbnail', 20 );


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



/* Register themes's custom blocks */

add_action( 'init', 'register_c4aa_org_blocks' );

function register_c4aa_org_blocks() {
    register_block_type( dirname(__FILE__) . '/blocks/person-title');
    register_block_type( dirname(__FILE__) . '/blocks/person-email' );
	register_block_type( dirname(__FILE__) . '/blocks/promo-image' );
}

/* Register Block Category */
function example_filter_block_categories_when_post_provided( $block_categories, $editor_context ) {
    if ( ! empty( $editor_context->post ) ) {
        array_push(
            $block_categories,
            array(
                'slug'  => 'people-category',
                'title' => __( 'C4AA People', 'c4aa-org-theme' ),
                'icon'  => 'groups'
            )
        );
    }
    return $block_categories;
}
add_filter( 'block_categories_all', 'example_filter_block_categories_when_post_provided', 10, 2 );


/* oEmbeds */

function c4aa_add_custom_styles_to_embeds()
{

?>
    <style>
        .wp-embed {
			font-family: "Work Sans", Helvetica Neue, Helvetica, Arial, sans-serif !important;
			border: 1rem solid #f9f4d2 !important;
            background-color: #fffef6 !important;
            color: #292724 !important;
        }

		.wp-embed .wp-embed-heading, .wp-embed .wp-embed-site-title {
			font-family: "Zilla Slab", Courier Bold, Courier, Georgia, Times, Times New Roman, serif;
		}

		.wp-embed .wp-embed-heading a {
			text-decoration: underline;
    		text-decoration-style: dotted;
    		text-decoration-thickness: 10%;
			text-underline-offset: 0.2em;
		}

		.wp-embed .wp-embed-heading a:hover {
			text-decoration: underline;
    		text-decoration-style: solid;
    		text-decoration-thickness: 10%;
			text-underline-offset: 0.2em;
			text-decoration-skip-ink: none;
		}

		.wp-embed .wp-embed-site-title {
			text-transform: uppercase;
			font-weight: 400;			
		}

		.wp-embed .wp-embed-site-title span {
			color: #292724
		}	

		.wp-embed a.wp-embed-more {
			text-decoration: underline;
    		text-decoration-style: dotted;
    		text-decoration-thickness: 10%;
			text-underline-offset: 0.2em;
			color: #f5333f;
		}

		.wp-embed a.wp-embed-more:hover {
			text-decoration: underline;
    		text-decoration-style: solid;
    		text-decoration-thickness: 10%;
			text-underline-offset: 0.2em;
		}

        .wp-embed .button {
            color: #7B736c;
        }

		.wp-embed .button:hover {
			color: #27aae1;
		}

    </style>

<?php
}
add_action('embed_head', "c4aa_add_custom_styles_to_embeds");
