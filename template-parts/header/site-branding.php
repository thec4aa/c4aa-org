<?php
/**
 * Displays header site branding
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */
?>

<header class="mobile-header">
	<a href="/" class="">
		<img src="https://c4aa.local/wp-content/themes/c4aa-org/img/logo-c4aa-red.png" alt="" class="logo-c4aa-mobile logo-c4aa-mobile--red active">
		<img src="https://c4aa.local/wp-content/themes/c4aa-org/img/logo-c4aa-white.png" alt="" class="logo-c4aa-mobile logo-c4aa-mobile--white">
	</a><!-- / -->
	<div class="menu-toggle" aria-controls="site-navigation" aria-expanded="false">
		<span class="bar"></span>
		<span class="bar"></span>
		<span class="bar"></span>
	</div>
</header><!-- / -->

<div class="site-branding">

	<?php if ( has_custom_logo() ) : ?>
		<div class="site-logo"><?php the_custom_logo(); ?></div>
	<?php endif; ?>
	<?php $blog_info = get_bloginfo( 'name' ); ?>
	<?php if ( ! empty( $blog_info ) ) : ?>
		<?php if ( is_front_page() && is_home() ) : ?>
			<h1 class="site-title">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<span class="c4aa-text-logo" style="background-image: url('<?php echo esc_url( get_stylesheet_directory_uri() . '/img/logo-c4aa-red.png' ); ?> ');">
					</span>
					<span class="c4aa-sr-only"><?php bloginfo( 'name' ); ?></span>
				</a>
			</h1>
		<?php else : ?>
			<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<span class="c4aa-text-logo" style="background-image: url('<?php echo esc_url( get_stylesheet_directory_uri() . '/img/logo-c4aa-red.png' ); ?> ');">
					</span>
					<span class="c4aa-sr-only"><?php bloginfo( 'name' ); ?></span>
				</a>
			</p>
		<?php endif; ?>
	<?php endif; ?>
	<?php if ( has_nav_menu( 'menu-1' ) ) : ?>
		<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Top Menu', 'twentynineteen' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-1',
					'menu_class'     => 'main-menu',
					'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				)
			);
			?>
		</nav><!-- #site-navigation -->
	<?php endif; ?>
	<?php if ( has_nav_menu( 'social' ) ) : ?>
		<nav class="social-navigation" aria-label="<?php esc_attr_e( 'Social Links Menu', 'twentynineteen' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'social',
					'menu_class'     => 'social-links-menu',
					'link_before'    => '<span class="screen-reader-text">',
					'link_after'     => '</span>' . twentynineteen_get_icon_svg( 'link' ),
					'depth'          => 1,
				)
			);
			?>
		</nav><!-- .social-navigation -->
	<?php endif; ?>
</div><!-- .site-branding -->
