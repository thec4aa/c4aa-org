<?php
// Displays primary portrait of the person
// Information added via custom fields on the Person Post Type
    $image = get_field( 'person-main-portrait', get_the_ID() );
    if ( $image ) : ?>
    <figure class="testimonial__image">
        <?php echo wp_get_attachment_image( $image['ID'], 'full', '', array( 'class' => 'testimonial__img' ) ); ?>
    </figure>
<?php endif; ?>