<?php
$align     = isset( $block['align_text'] ) ? $block['align_text'] : 'left';
$textcolor = isset( $block['textColor'] ) ? $block['textColor'] : 'inherit';

if ( substr( $textcolor, 0, 1 ) !== '#' && substr( $textcolor, 0, 4 ) !== 'rgb(' ) {
    $textcolor = 'var(--wp--preset--color--' . $textcolor . ')';
}
?>
<aside class="person-title" style="color: <?php echo $textcolor; ?>; text-align: <?php echo $align; ?>">
    <?php $person_title = get_field( 'person-title', get_the_ID() ); ?>
    <?php if ( ! empty( $person_title ) ) { ?>
            <p>
                <?php echo $person_title; ?>
            </p>
        <?php } ?>
</aside>