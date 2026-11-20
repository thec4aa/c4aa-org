<?php
/**
 * One-off content migration: old c4aa duotone block styles -> core duotone presets.
 *
 * Until 2021 or so the theme offered image block styles named
 * is-style-c4aa-duotone-<base>-and-<foreground>, tinted by CSS blend modes in
 * src/css/_c4aa-imageFilter.scss. They were later removed from the editor but
 * roughly 300 blocks across 76 posts and pages still carry the classes. This
 * script moves each of them to the matching theme.json duotone preset so the
 * old CSS can go.
 *
 * The naming is reversed between the two systems: the old style put the first
 * colour behind the image (so highlights take it) and screened the second one
 * over the shadows; core lists shadow first, highlight second. So
 * beige-and-black becomes black-and-beige, and so on.
 *
 * Usage, from the WordPress root, with WP-CLI:
 *
 *   wp eval-file wp-content/themes/c4aa-org/bin/migrate-duotone-styles.php report
 *   wp eval-file wp-content/themes/c4aa-org/bin/migrate-duotone-styles.php apply 1234 --user=<admin>
 *   wp eval-file wp-content/themes/c4aa-org/bin/migrate-duotone-styles.php apply --user=<admin>
 *
 * "report" only prints what would change. "apply" writes through
 * wp_update_post, so every post gets a revision to roll back to. It needs
 * --user with an admin login so kses doesn't strip anything from the saved
 * content; it refuses to run otherwise. Optional post IDs after the mode
 * limit the run to those posts.
 *
 * The transform is plain string work on the block comments and class
 * attributes rather than a parse_blocks/serialize_blocks round trip, so the
 * rest of each post is left byte for byte as the editor saved it.
 */

/**
 * Old block style class -> core duotone preset slug (from theme.json).
 */
function c4aa_duotone_style_map() {
	return array(
		'is-style-c4aa-duotone-beige-and-black'        => 'black-and-beige',
		'is-style-c4aa-duotone-beige-and-red'          => 'red-and-beige',
		'is-style-c4aa-duotone-beige-and-grey'         => 'grey-and-beige',
		// There was never a vintage theme; the substring selector made it
		// render as beige-and-grey, so that is what it stays.
		'is-style-c4aa-duotone-beige-and-grey-vintage' => 'grey-and-beige',
		'is-style-c4aa-duotone-red-and-black'          => 'black-and-red',
		// The bare class (galleries) has no colour of its own; see
		// c4aa_duotone_bare_preset() for where it gets one.
		'is-style-c4aa-duotone'                        => null,
	);
}

/**
 * Preset for the bare is-style-c4aa-duotone class.
 *
 * With no colour in the class the old CSS fell through to whatever the body
 * carried from the post's ACF image filter (the same <base>-and-<foreground>
 * names), and failing that to its defaults, white base and black foreground.
 * Core names the pair the other way round, so swap the halves.
 */
function c4aa_duotone_bare_preset( $body_filter ) {
	$presets = array(
		'black-and-white', 'black-and-beige', 'black-and-red', 'grey-and-red', 'red-and-beige',
		'red-and-white', 'black-and-grey', 'grey-and-white', 'grey-and-beige', 'black-and-blue',
		'grey-and-blue', 'blue-and-white', 'blue-and-beige', 'black-and-green', 'grey-and-green',
		'green-and-white', 'green-and-beige', 'black-and-purple', 'grey-and-purple',
		'purple-and-white', 'purple-and-beige', 'black-and-yellow', 'grey-and-yellow',
		'yellow-and-white', 'yellow-and-beige', 'red-and-blue', 'blue-and-red',
	);
	if ( 'none' === $body_filter ) {
		// The old CSS reset every variable under a "none" body, so these
		// galleries showed no tint at all. Nothing sensible to map to.
		return null;
	}
	if ( $body_filter && preg_match( '/^([a-z]+)-and-([a-z]+)$/', $body_filter, $m ) ) {
		$swapped = $m[2] . '-and-' . $m[1];
		if ( in_array( $swapped, $presets, true ) ) {
			return $swapped;
		}
		return null;
	}
	return 'black-and-white';
}

/**
 * Encode block attributes the way the editor does (serializeAttributes in
 * @wordpress/blocks): JSON with --, <, >, & and escaped quotes turned into
 * unicode escapes so they can't close the HTML comment. Slashes and
 * non-ASCII are left alone, matching JSON.stringify.
 */
function c4aa_duotone_encode_attrs( array $attrs ) {
	$json = json_encode( $attrs, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
	$json = str_replace( '--', '\\u002d\\u002d', $json );
	$json = str_replace( '<', '\\u003c', $json );
	$json = str_replace( '>', '\\u003e', $json );
	$json = str_replace( '&', '\\u0026', $json );
	$json = str_replace( '\\"', '\\u0022', $json );
	return $json;
}

/**
 * Rewrite one post's content.
 *
 * @param string $content     Raw post_content.
 * @param array  $log         Filled with 'changes' (one line per block) and
 *                            'warnings' (anything that needs a human).
 * @param string $body_filter The post's ACF c4aa_image_filter value, if any.
 * @return string New content; identical to $content when nothing applied.
 */
function c4aa_duotone_migrate_content( $content, array &$log, $body_filter = '' ) {
	$map            = c4aa_duotone_style_map();
	$map['is-style-c4aa-duotone'] = c4aa_duotone_bare_preset( $body_filter );
	$log            = array( 'changes' => array(), 'warnings' => array() );
	$attr_removed   = 0;
	$class_removed  = 0;

	// 1. Block comment openers for image and gallery blocks.
	$content = preg_replace_callback(
		'/<!-- wp:(image|gallery) (\{.*?\}) -->/',
		function ( $m ) use ( $map, $body_filter, &$log, &$attr_removed ) {
			$block = $m[1];
			$attrs = json_decode( $m[2], true );
			if ( ! is_array( $attrs ) || empty( $attrs['className'] ) ) {
				return $m[0];
			}

			$tokens = preg_split( '/\s+/', trim( $attrs['className'] ) );
			$old    = array_values( array_intersect( $tokens, array_keys( $map ) ) );
			if ( ! $old ) {
				return $m[0];
			}
			if ( count( $old ) > 1 ) {
				$log['warnings'][] = "$block block carries several old styles (" . implode( ', ', $old ) . '); used the first';
			}

			// Any other c4aa-duotone-ish token we don't know is left in place and flagged.
			foreach ( $tokens as $t ) {
				if ( 0 === strpos( $t, 'is-style-c4aa-duotone' ) && ! array_key_exists( $t, $map ) ) {
					$log['warnings'][] = "$block block has unknown style class $t; left as is";
				}
			}

			$preset = $map[ $old[0] ];
			if ( null === $preset ) {
				$log['warnings'][] = "$block block has the bare duotone class and the post's image filter \"$body_filter\" has no core preset; left as is";
				return $m[0];
			}
			$keep   = array_values( array_diff( $tokens, $old ) );
			if ( $keep ) {
				$attrs['className'] = implode( ' ', $keep );
			} else {
				unset( $attrs['className'] );
			}

			if ( isset( $attrs['style']['color']['duotone'] ) ) {
				$log['warnings'][] = "$block block already has duotone {$attrs['style']['color']['duotone']}; kept it, dropped {$old[0]}";
			} else {
				if ( ! isset( $attrs['style'] ) || ! is_array( $attrs['style'] ) ) {
					$attrs['style'] = array();
				}
				if ( ! isset( $attrs['style']['color'] ) || ! is_array( $attrs['style']['color'] ) ) {
					$attrs['style']['color'] = array();
				}
				$attrs['style']['color']['duotone'] = 'var:preset|duotone|' . $preset;
			}

			$attr_removed += count( $old );
			$log['changes'][] = isset( $attrs['style']['color']['duotone'] ) && 'var:preset|duotone|' . $preset !== $attrs['style']['color']['duotone']
				? "$block: {$old[0]} dropped, kept existing duotone"
				: "$block: {$old[0]} -> $preset";

			return '<!-- wp:' . $block . ' ' . c4aa_duotone_encode_attrs( $attrs ) . ' -->';
		},
		$content
	);

	// 2. The same classes in the saved HTML (figure or wrapping div).
	$content = preg_replace_callback(
		'/ class="([^"]*)"/',
		function ( $m ) use ( $map, &$class_removed ) {
			if ( false === strpos( $m[1], 'is-style-c4aa-duotone' ) ) {
				return $m[0];
			}
			$tokens = preg_split( '/\s+/', trim( $m[1] ) );
			// Only the blocks step 1 handles; leave anything else for the report.
			if ( ! in_array( 'wp-block-image', $tokens, true ) && ! in_array( 'wp-block-gallery', $tokens, true ) ) {
				return $m[0];
			}
			$keep   = array();
			foreach ( $tokens as $t ) {
				if ( isset( $map[ $t ] ) ) {
					$class_removed++;
				} else {
					$keep[] = $t;
				}
			}
			return $keep ? ' class="' . implode( ' ', $keep ) . '"' : '';
		},
		$content
	);

	if ( $attr_removed !== $class_removed ) {
		$log['warnings'][] = "removed $attr_removed style attributes but $class_removed HTML classes; check the markup by hand";
	}

	// 3. Anything left over means a block type we didn't handle.
	if ( preg_match_all( '/<!-- wp:([a-z\/-]+) [^\n]*is-style-c4aa-duotone/', $content, $mm ) ) {
		foreach ( array_unique( $mm[1] ) as $type ) {
			$log['warnings'][] = "old style class still present on an unhandled $type block";
		}
	}

	return $content;
}

/**
 * WP-CLI entry point.
 */
function c4aa_duotone_migrate_main( array $args ) {
	global $wpdb;

	$mode = array_shift( $args );
	if ( ! in_array( $mode, array( 'report', 'apply' ), true ) ) {
		WP_CLI::error( 'First argument must be "report" or "apply".' );
	}
	$only_ids = array_map( 'intval', $args );

	if ( 'apply' === $mode && ! current_user_can( 'unfiltered_html' ) ) {
		WP_CLI::error( 'Run apply with --user=<admin login>, otherwise kses would filter the saved content.' );
	}

	$sql = "SELECT ID FROM {$wpdb->posts}
		WHERE post_content LIKE '%is-style-c4aa-duotone%'
		AND post_type NOT IN ('revision', 'taxopress_logs')
		AND post_status NOT IN ('auto-draft', 'trash')";
	// taxopress_logs are TaxoPress's own copies of post content; not ours to edit.
	if ( $only_ids ) {
		$sql .= ' AND ID IN (' . implode( ',', $only_ids ) . ')';
	}
	$ids = $wpdb->get_col( $sql . ' ORDER BY ID' );

	WP_CLI::log( sprintf( '%s: %d post(s) carry an old duotone style class', $mode, count( $ids ) ) );

	$totals   = array();
	$warned   = 0;
	$written  = 0;

	foreach ( $ids as $id ) {
		$post   = get_post( $id );
		$log    = array();
		$filter = function_exists( 'get_field' ) ? (string) get_field( 'c4aa_image_filter', $id ) : '';
		$new    = c4aa_duotone_migrate_content( $post->post_content, $log, $filter );

		WP_CLI::log( '' );
		WP_CLI::log( sprintf( '#%d %s/%s "%s" %s%s', $id, $post->post_type, $post->post_status, $post->post_title, get_permalink( $post ), $filter ? " [body filter: $filter]" : '' ) );
		foreach ( $log['changes'] as $c ) {
			WP_CLI::log( '  ' . $c );
			$totals[ $c ] = ( $totals[ $c ] ?? 0 ) + 1;
		}
		foreach ( $log['warnings'] as $w ) {
			WP_CLI::warning( "#$id: $w" );
		}
		if ( $log['warnings'] ) {
			$warned++;
		}

		if ( 'apply' !== $mode || $new === $post->post_content ) {
			continue;
		}
		if ( $log['warnings'] ) {
			WP_CLI::log( '  skipped: has warnings, fix by hand' );
			continue;
		}

		$result = wp_update_post(
			array(
				'ID'           => $id,
				'post_content' => wp_slash( $new ),
			),
			true
		);
		if ( is_wp_error( $result ) ) {
			WP_CLI::warning( "#$id: save failed: " . $result->get_error_message() );
			continue;
		}
		clean_post_cache( $id );
		if ( get_post( $id )->post_content !== $new ) {
			WP_CLI::warning( "#$id: saved content differs from what we sent; check it" );
			continue;
		}
		$written++;
		WP_CLI::log( '  saved' );
	}

	WP_CLI::log( '' );
	WP_CLI::log( 'Totals:' );
	ksort( $totals );
	foreach ( $totals as $change => $n ) {
		WP_CLI::log( sprintf( '  %4d  %s', $n, $change ) );
	}
	WP_CLI::log( sprintf( '%d post(s) with warnings', $warned ) );
	if ( 'apply' === $mode ) {
		WP_CLI::success( "$written post(s) updated" );
	}
}

if ( defined( 'WP_CLI' ) && WP_CLI && defined( 'ABSPATH' ) ) {
	c4aa_duotone_migrate_main( isset( $args ) && is_array( $args ) ? $args : array() );
}
