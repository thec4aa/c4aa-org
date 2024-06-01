<?php
$align     = isset( $block['align_text'] ) ? $block['align_text'] : 'left';
$textcolor = isset( $block['textColor'] ) ? $block['textColor'] : 'inherit';

if ( substr( $textcolor, 0, 1 ) !== '#' && substr( $textcolor, 0, 4 ) !== 'rgb(' ) {
    $textcolor = 'var(--wp--preset--color--' . $textcolor . ')';
}
?>
<aside class="person-email" style="color: <?php echo $textcolor; ?>; text-align: <?php echo $align; ?>">
    <?php $person_email = get_field( 'person-email', get_the_ID() ); ?>
    <?php if ( ! empty( $person_email ) ) { ?>
            <p>
                <?php echo antispambot( $person_email ); ?>
            </p>
        <?php } ?>
</aside>