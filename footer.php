<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<?php get_template_part( 'template-parts/footer/footer', 'widgets' ); ?>
		<div class="site-info u-flex u-align-items-center wp-block-columns has-3-columns">

			<div class="wp-block-column" style="flex-basis:42.5%">
				<p>
					<div class="u-display-inline-block">
						<a href="https://creativecommons.org/licenses/by-nc-sa/4.0/"><?php echo file_get_contents( get_stylesheet_directory() . '/svg/cc.logo.circle.svg' ); ?></a>
					</div>
					<?php $blog_info = get_bloginfo( 'name' ); ?>
					<?php if ( ! empty( $blog_info ) ) : ?>
						<a class="site-name" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
					<?php endif; ?>
					<br />
					New York, USA  &nbsp;• &nbsp;+1 (646) 832-2454
				</p>

			</div>
				
			<div class="wp-block-column has-text-align-center" style="flex-basis:15%">

				<div class="u-width-100 u-display-inline-block">
					<?php echo file_get_contents( get_stylesheet_directory() . '/svg/c4aa.magic.hand.svg' ); ?>
				</div>

			</div>

			<div class="wp-block-column has-text-align-right" style="flex-basis:42.5%">

				<?php
				if ( function_exists( 'the_privacy_policy_link' ) ) {
					the_privacy_policy_link( '', '<span role="separator" aria-hidden="true"></span>' );
				}
				?>

				<?php if ( has_nav_menu( 'footer' ) ) : ?>
					<nav class="footer-navigation" aria-label="<?php esc_attr_e( 'Footer Menu', 'twentynineteen' ); ?>">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'footer',
								'menu_class'     => 'footer-menu',
								'depth'          => 1,
							)
						);
						?>
					</nav><!-- .footer-navigation -->
				<?php endif; ?>
			</div>

		</div><!-- .site-info -->
	</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
