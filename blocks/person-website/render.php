<?php
// Displays a linked website of the person
// Information added via custom fields on the Person Post Type

$align     = isset( $block['align_text'] ) ? $block['align_text'] : 'left';
$textcolor = isset( $block['textColor'] ) ? $block['textColor'] : 'inherit';

if ( substr( $textcolor, 0, 1 ) !== '#' && substr( $textcolor, 0, 4 ) !== 'rgb(' ) {
    $textcolor = 'var(--wp--preset--color--' . $textcolor . ')';
}
?>
<aside class="person-website-title" style="color: <?php echo $textcolor; ?>; text-align: <?php echo $align; ?>">
    <?php $person_website_title = get_field( 'person-website-title', get_the_ID() ); ?>
    <?php $person_website_url = get_field( 'person-website-url', get_the_ID() ); ?>
    <?php if ( ! empty( $person_website_title ) ) { ?>
            <p>            
                <a href="<?php echo esc_url( $person_website_url ); ?>" target="_blank" rel="noopener noreferrer">
                    <?php echo esc_html( $person_website_title ); ?>
            </p>

        <?php } ?>
</aside>