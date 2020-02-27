<?php
function twentytwenty_child_theme_enqueue_scripts() {
    wp_register_style( 'childstyle', get_stylesheet_directory_uri() . '/style.css', array(), '1.0.0', "all"  );
    wp_enqueue_style( 'childstyle' );
}
add_action( 'wp_enqueue_scripts', 'twentytwenty_child_theme_enqueue_scripts', 11);