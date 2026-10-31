<?php
// add code to display promo-image block:
$image = get_field('promo-image', get_the_ID());

// In the editor ACF supplies the wrapper; on the front end we have to, or the
// aspect ratio, spacing and duotone chosen in the sidebar never reach the page.
$wrapper = ! empty( $is_preview )
	? 'class="acf-promo-image-container"'
	: get_block_wrapper_attributes( array( 'class' => 'acf-promo-image-container' ) );
?>
<div <?php echo $wrapper; ?>>
    <?php
    if (!empty($image)): ?>
        <img class="acf-promo-image" src="<?php echo esc_url($image['url']); ?>"
            alt="<?php echo esc_attr($image['alt']); ?>" />

    <?php elseif (has_post_thumbnail()): ?>
        <?php the_post_thumbnail('medium_large'); // add code to display a default image or message when no image is provided ?>

    <?php endif; ?>
</div>