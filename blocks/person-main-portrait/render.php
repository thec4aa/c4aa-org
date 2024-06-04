<?php
// Displays primary portrait of the person
// Information added via custom fields on the Person Post Type
    $image = get_field( 'person-main-portrait', get_the_ID() );
    if ( $image ) : ?>
    <figure class="person_figure__image">
    <a href="<?php echo esc_url( get_permalink());?>" class="person-img-link"><?php echo wp_get_attachment_image( $image['ID'], 'full', '', array( 'class' => 'person__img' ) ); ?></a>
    </figure>
<?php endif; ?>