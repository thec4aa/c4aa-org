<?php
// add code to display promo-image block:
$image = get_field('promo-image', get_the_ID());
 
if( !empty( $image ) ): ?>
    <img class="acf-promo-image" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />

<?php elseif (has_post_thumbnail()) : ?>
    <p>no promo image</p>
    <?php the_post_thumbnail('medium_large'); // add code to display a default image or message when no image is provided ?>

<?php endif; ?>
	