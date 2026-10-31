<?php
// Displays a linked email of the person
// Information added via custom fields on the Person Post Type
// On the front end, get_block_wrapper_attributes() carries the colour, size,
// alignment and spacing chosen in the editor. In the editor preview WordPress
// already wraps the block and applies those itself, so we only add our class.
$wrapper = ! empty( $is_preview )
	? 'class="person-email"'
	: get_block_wrapper_attributes( array( 'class' => 'person-email' ) );
?>
<aside <?php echo $wrapper; ?>>
    <?php $person_email = get_field( 'person-email', get_the_ID() ); ?>
    <?php if ( ! empty( $person_email ) ) { ?>
            <p>
                <!-- add a mailto link that uses the antispambot and can be clicked on by the user. -->
                <a href="mailto:<?php echo antispambot( $person_email ); ?>"><?php echo antispambot( $person_email ); ?></a>
            </p>
        <?php } ?>
</aside>
