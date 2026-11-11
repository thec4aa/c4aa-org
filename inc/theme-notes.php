<?php
/**
 * C4AA Theme Notes
 *
 * Reference page for staff who edit the site: image sizes, colours, the
 * featured image options and the theme's extra block styles and classes.
 * It lives under Dashboard rather than Appearance because editors can't
 * see the Appearance menu.
 *
 * The colour table is read from theme.json so it can't drift from the
 * palette. Everything else is written out by hand, so update it here when
 * the theme changes.
 */

function c4aa_theme_notes_menu() {
	add_dashboard_page(
		__( 'C4AA Theme Notes', 'c4aa-org' ),
		__( 'C4AA Theme Notes', 'c4aa-org' ),
		'edit_posts',
		'c4aa-theme-notes',
		'c4aa_theme_notes_page'
	);
}
add_action( 'admin_menu', 'c4aa_theme_notes_menu' );

/**
 * The dashboard widget used to hold the notes. Now it just points at the page.
 */
function c4aa_custom_dashboard_widgets() {
	wp_add_dashboard_widget( 'custom_help_widget', __( 'C4AA Theme Notes', 'c4aa-org' ), 'c4aa_custom_dashboard_help' );
}
add_action( 'wp_dashboard_setup', 'c4aa_custom_dashboard_widgets' );

function c4aa_custom_dashboard_help() {
	?>
	<p><?php esc_html_e( 'Image sizes, colours, featured image options and the extra block styles this theme adds.', 'c4aa-org' ); ?></p>
	<p><a class="button button-primary" href="<?php echo esc_url( admin_url( 'index.php?page=c4aa-theme-notes' ) ); ?>"><?php esc_html_e( 'Open the theme notes', 'c4aa-org' ); ?></a></p>
	<?php
}

/**
 * WCAG contrast ratio between two hex colours.
 */
function c4aa_contrast_ratio( $hex_a, $hex_b ) {
	$luminance = function ( $hex ) {
		$hex = ltrim( $hex, '#' );
		$rgb = array();
		foreach ( array( 0, 2, 4 ) as $i ) {
			$c     = hexdec( substr( $hex, $i, 2 ) ) / 255;
			$rgb[] = $c <= 0.03928 ? $c / 12.92 : pow( ( $c + 0.055 ) / 1.055, 2.4 );
		}
		return 0.2126 * $rgb[0] + 0.7152 * $rgb[1] + 0.0722 * $rgb[2];
	};

	$l = array( $luminance( $hex_a ), $luminance( $hex_b ) );
	return ( max( $l ) + 0.05 ) / ( min( $l ) + 0.05 );
}

/**
 * One table cell showing a colour's contrast against a background, with a
 * verdict: 4.5 is the minimum for body text, 3 for large headings.
 */
function c4aa_theme_notes_contrast_cell( $color, $background ) {
	$ratio = c4aa_contrast_ratio( $color, $background );

	if ( $ratio >= 4.5 ) {
		$verdict = __( 'any text', 'c4aa-org' );
	} elseif ( $ratio >= 3 ) {
		$verdict = __( 'large headings only', 'c4aa-org' );
	} else {
		$verdict = __( 'not for text', 'c4aa-org' );
	}

	printf(
		'<td><span class="c4aa-notes-sample" style="color:%1$s;background:%2$s">Aa</span> %3$s &middot; %4$s</td>',
		esc_attr( $color ),
		esc_attr( $background ),
		esc_html( number_format( $ratio, 1 ) ),
		esc_html( $verdict )
	);
}

function c4aa_theme_notes_page() {
	$palette = wp_get_global_settings( array( 'color', 'palette', 'theme' ) );
	$colors  = wp_list_pluck( $palette, 'color', 'slug' );
	$light   = $colors['base'] ?? '#fffef6';
	$dark    = $colors['contrast'] ?? '#292724';

	$block_styles = array(
		array( __( 'Button', 'c4aa-org' ), __( 'High Emphasis / Low Emphasis', 'c4aa-org' ), __( 'High for the one main action on a page, Low for everything else.', 'c4aa-org' ) ),
		array( __( 'Heading', 'c4aa-org' ), __( 'C4AA Banner', 'c4aa-org' ), __( 'Puts the heading on a slightly skewed colour banner.', 'c4aa-org' ) ),
		array( __( 'List', 'c4aa-org' ), __( 'No Bullets', 'c4aa-org' ), '' ),
		array( __( 'Query Loop', 'c4aa-org' ), __( 'Primary Cycle, Primary + Blue/Green/Purple/Yellow', 'c4aa-org' ), __( 'Cycles the background colour of each post in the loop.', 'c4aa-org' ) ),
		array( __( 'Most blocks', 'c4aa-org' ), __( 'Random Rotation', 'c4aa-org' ), __( 'Tilts the block a little, differently on each page load. Use sparingly.', 'c4aa-org' ) ),
	);

	$classes = array(
		array( 'no-hyphens', __( 'Turns off automatic hyphenation for everything in the block.', 'c4aa-org' ) ),
		array( 'u-duotone-sticky', __( 'On an image block with a duotone, keeps the duotone on hover instead of fading to full colour.', 'c4aa-org' ) ),
		array( 'u-rotate-1 … u-rotate-4, u-rotate-neg1 … u-rotate-neg4', __( 'Tilts the block by that many degrees. Also u-rotate-45, -90, -180 and their neg versions.', 'c4aa-org' ) ),
		array( 'u-flip-horizontal', __( 'Mirrors the block.', 'c4aa-org' ) ),
		array( 'u-multiply, u-darken, u-no-mix', __( 'Blend modes, for images or shapes laid over colour.', 'c4aa-org' ) ),
		array( 'u-opacity-90, u-opacity-95, u-opacity-100', __( 'Makes the block slightly see-through, or forces it fully solid.', 'c4aa-org' ) ),
		array( 'u-min-height-100vh, u-min-height-80vh', __( 'Makes the block at least the full (or 80% of the) screen height.', 'c4aa-org' ) ),
		array( 'u-text-align-center, u-text-align-right', __( 'Aligns text where the block has no alignment control.', 'c4aa-org' ) ),
		array( 'u-image-text-card', __( 'On a group with an image above text, removes the gap under the image.', 'c4aa-org' ) ),
	);
	?>
	<style>
		.c4aa-notes { max-width: 960px; }
		.c4aa-notes h2 { margin-top: 2.5em; }
		.c4aa-notes p, .c4aa-notes li { font-size: 14px; max-width: 70ch; }
		.c4aa-notes ul { list-style: disc; padding-left: 1.5em; }
		.c4aa-notes-swatch { display: inline-block; width: 1.5em; height: 1.5em; vertical-align: middle; margin-right: .5em; border: 1px solid #ccc; }
		.c4aa-notes-sample { display: inline-block; padding: 0 .4em; font-weight: 600; border: 1px solid #ccc; }
	</style>

	<div class="wrap c4aa-notes">
		<h1><?php esc_html_e( 'C4AA Theme Notes', 'c4aa-org' ); ?></h1>
		<p><?php esc_html_e( 'Reference for editing c4aa.org. If something here is wrong or missing, ask Steve Lambert.', 'c4aa-org' ); ?></p>

		<h2 id="images"><?php esc_html_e( 'Images', 'c4aa-org' ); ?></h2>
		<ul>
			<li><strong><?php esc_html_e( 'Featured images:', 'c4aa-org' ); ?></strong> <?php esc_html_e( 'upload the largest version you have, ideally 2000px wide or more. On posts and pages they fill the whole width of the screen.', 'c4aa-org' ); ?></li>
			<li><?php esc_html_e( 'Featured images are cropped to fit the header, and how much gets cut off depends on the screen. Keep the subject near the centre and avoid text in the image.', 'c4aa-org' ); ?></li>
			<li><strong><?php esc_html_e( 'Images in the post body:', 'c4aa-org' ); ?></strong> <?php esc_html_e( '1600px wide is plenty. The text column is 840px, 1100px for "wide" images.', 'c4aa-org' ); ?></li>
			<li><?php esc_html_e( "Don't shrink or compress images yourself. The site compresses uploads and makes smaller copies, and each visitor's browser picks the size it needs.", 'c4aa-org' ); ?></li>
			<li><?php esc_html_e( 'Write alt text that says what the image shows, for people using screen readers. Leave it empty only if the image is purely decorative.', 'c4aa-org' ); ?></li>
		</ul>

		<h2 id="featured-image-options"><?php esc_html_e( 'Image filter and title banner', 'c4aa-org' ); ?></h2>
		<p><?php esc_html_e( 'Posts and pages have two options in the editor sidebar that style the featured image header:', 'c4aa-org' ); ?></p>
		<ul>
			<li><strong><?php esc_html_e( 'Image filter', 'c4aa-org' ); ?></strong> &mdash; <?php esc_html_e( 'a two-colour (duotone) treatment for the featured image. It also applies wherever the post shows up in archives and lists. Use only one colour from the secondary palette (blue, green, purple, yellow).', 'c4aa-org' ); ?></li>
			<li><strong><?php esc_html_e( 'Title effect', 'c4aa-org' ); ?></strong> &mdash; <?php esc_html_e( 'a colour banner behind the page title. Go for contrast, and avoid a banner in the same colour as the image filter.', 'c4aa-org' ); ?></li>
		</ul>
		<p><?php esc_html_e( 'Image blocks inside the post have their own duotone setting in the block toolbar. Those images fade to full colour when someone hovers over them, unless you add the u-duotone-sticky class.', 'c4aa-org' ); ?></p>

		<h2 id="colours"><?php esc_html_e( 'Colours', 'c4aa-org' ); ?></h2>
		<p><?php esc_html_e( 'Use colours from the colour picker rather than custom ones. The primary palette is red, black, cream, beige and grey; blue, green, purple and yellow are secondary. Stick to one secondary colour per page.', 'c4aa-org' ); ?></p>
		<p><?php esc_html_e( 'Several brand colours are too light to read as text on the cream background. The table shows each colour as text on the two page colours. Contrast of 4.5 or more is readable at any size, 3 or more works for large headings only.', 'c4aa-org' ); ?></p>
		<table class="widefat striped">
			<thead>
				<tr>
					<th><?php esc_html_e( 'Colour', 'c4aa-org' ); ?></th>
					<th><?php esc_html_e( 'As text on cream', 'c4aa-org' ); ?></th>
					<th><?php esc_html_e( 'As text on black', 'c4aa-org' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $palette as $entry ) : ?>
					<tr>
						<td><span class="c4aa-notes-swatch" style="background:<?php echo esc_attr( $entry['color'] ); ?>"></span><?php echo esc_html( $entry['name'] ); ?> <code><?php echo esc_html( $entry['color'] ); ?></code></td>
						<?php
						c4aa_theme_notes_contrast_cell( $entry['color'], $light );
						c4aa_theme_notes_contrast_cell( $entry['color'], $dark );
						?>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<h2 id="block-styles"><?php esc_html_e( 'Block styles', 'c4aa-org' ); ?></h2>
		<p><?php esc_html_e( 'Select a block and look under Styles in the block settings sidebar.', 'c4aa-org' ); ?></p>
		<table class="widefat striped">
			<thead>
				<tr>
					<th><?php esc_html_e( 'Block', 'c4aa-org' ); ?></th>
					<th><?php esc_html_e( 'Style', 'c4aa-org' ); ?></th>
					<th><?php esc_html_e( 'What it does', 'c4aa-org' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $block_styles as $row ) : ?>
					<tr>
						<td><?php echo esc_html( $row[0] ); ?></td>
						<td><?php echo esc_html( $row[1] ); ?></td>
						<td><?php echo esc_html( $row[2] ); ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<h2 id="classes"><?php esc_html_e( 'Extra CSS classes', 'c4aa-org' ); ?></h2>
		<p><?php esc_html_e( 'Add these under Advanced → Additional CSS class(es) in the block settings sidebar. Separate several with spaces.', 'c4aa-org' ); ?></p>
		<table class="widefat striped">
			<thead>
				<tr>
					<th><?php esc_html_e( 'Class', 'c4aa-org' ); ?></th>
					<th><?php esc_html_e( 'What it does', 'c4aa-org' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $classes as $row ) : ?>
					<tr>
						<td><code><?php echo esc_html( $row[0] ); ?></code></td>
						<td><?php echo esc_html( $row[1] ); ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<h2 id="c4aa-blocks"><?php esc_html_e( 'C4AA blocks', 'c4aa-org' ); ?></h2>
		<p><?php esc_html_e( 'These are in the C4AA category of the block inserter.', 'c4aa-org' ); ?></p>
		<ul>
			<li><strong><?php esc_html_e( "Person's Title / Person's Email Address", 'c4aa-org' ); ?></strong> &mdash; <?php esc_html_e( 'show the title and email from a People entry. Use them in People templates and query loops.', 'c4aa-org' ); ?></li>
			<li><strong><?php esc_html_e( 'Promo image', 'c4aa-org' ); ?></strong> &mdash; <?php esc_html_e( "shows the post's promo image (set in the editor sidebar, used for promotion and social media), or the featured image if there isn't one. Turn on its link option to make the image link to the post, which is handy in query loops.", 'c4aa-org' ); ?></li>
		</ul>
	</div>
	<?php
}
