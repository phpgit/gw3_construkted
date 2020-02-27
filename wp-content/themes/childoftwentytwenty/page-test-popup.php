<?php
/**
 * Template Name: side-menu-bar template
 * Template Post Type: post, page
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since 1.0
 */

get_header();
?>

<main id="site-content" role="main">
  
	<?php

	if ( have_posts() ) {

		// while ( have_posts() ) {
		// 	the_post();

		// 	get_template_part( 'template-parts/content-cover' );
		// }
	}

	?>
  <div id="side-menu-bar-wrapper">
    <?php 
      require_once __DIR__ . '/side-menu-bar/side-menu-bar-init.php';
    ?>
  </div>
</main><!-- #site-content -->

<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php get_footer(); ?>
