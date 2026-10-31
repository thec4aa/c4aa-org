<?php
// Displays the person's title, from a custom field on the People post type.
// On the front end, get_block_wrapper_attributes() carries the colour, size,
// alignment and spacing chosen in the editor. In the editor preview WordPress
// already wraps the block and applies those itself, so we only add our class.
$wrapper = ! empty( $is_preview )
	? 'class="person-title"'
	: get_block_wrapper_attributes( array( 'class' => 'person-title' ) );
?>
<aside <?php echo $wrapper; ?>>
    <?php $person_title = get_field( 'person-title', get_the_ID() ); ?>
    <?php if ( ! empty( $person_title ) ) { ?>
            <p>
                <?php echo $person_title; ?>
            </p>
        <?php } ?>
</aside>
