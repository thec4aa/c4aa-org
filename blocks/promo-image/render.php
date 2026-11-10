<?php
// add code to display promo-image block:
$image = get_field('promo-image', get_the_ID());

// Block setting, not post meta, so no post ID here.
$link = get_field('promo_image_link_to_post') ? get_permalink() : '';

// In the editor ACF supplies the wrapper; on the front end we have to, or the
// aspect ratio, spacing and duotone chosen in the sidebar never reach the page.
$wrapper = ! empty( $is_preview )
	? 'class="acf-promo-image-container"'
	: get_block_wrapper_attributes( array( 'class' => 'acf-promo-image-container' ) );

// The link's only content is the image, so an empty alt would leave it without a
// name. Fall back to the post title, like core's featured image block does.
$alt = ! empty( $image ) ? $image['alt'] : get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
if ( $link && '' === trim( (string) $alt ) ) {
	$alt = wp_strip_all_tags( get_the_title() );
}

// Not in the editor, where a click should select the block rather than navigate.
$wrap_in_link = $link && empty( $is_preview ) && ( ! empty( $image ) || has_post_thumbnail() );
?>
<div <?php echo $wrapper; ?>>
    <?php if ( $wrap_in_link ): ?>
        <a href="<?php echo esc_url( $link ); ?>">
    <?php endif; ?>

    <?php
    if (!empty($image)): ?>
        <img class="acf-promo-image" src="<?php echo esc_url($image['url']); ?>"
            alt="<?php echo esc_attr($alt); ?>" />

    <?php elseif (has_post_thumbnail()): ?>
        <?php the_post_thumbnail('medium_large', array( 'alt' => $alt )); // add code to display a default image or message when no image is provided ?>

    <?php endif; ?>

    <?php if ( $wrap_in_link ): ?>
        </a>
    <?php endif; ?>
</div>
