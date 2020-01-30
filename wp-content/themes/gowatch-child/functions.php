<?php

if (!defined('CONSTRUKTED_PATH')) {
    define('CONSTRUKTED_PATH', get_stylesheet_directory());
}

if (!defined('CS_LIB_VER')) {
    define('CS_LIB_VER', '1.0.0'); //library version of js and css
}

if (!defined('DEFAULT_DISK_QUOTA')) {
    define('DEFAULT_DISK_QUOTA', 0);
}

if (!defined('CONSTRUKTED_3D_TILE_SERVER_URL')) {
    define('CONSTRUKTED_3D_TILE_SERVER_URL', 'https://tile01.construkted.com/index.php/asset/');
}

if (!defined('CONSTRUKTED_TILING_SERVER_URL')) {
    define('CONSTRUKTED_TILING_SERVER', 'http://tile01.construkted.com:5000/request_tiling');
}

require(CONSTRUKTED_PATH . '/includes/functions.php');
require(CONSTRUKTED_PATH . '/includes/ajax.php');
require(CONSTRUKTED_PATH . '/includes/admin/admin.php');
require(CONSTRUKTED_PATH . '/includes/frontend-submission/includes/construkted/loader.php');

add_action('wp_enqueue_scripts', 'gowatch_child_enqueue_styles');

function gowatch_child_enqueue_styles()
{
    wp_enqueue_style('gowatch-child-style', get_stylesheet_directory_uri() . '/style.css', array('gowatch-style', 'gowatch-bootstrap'));
}

/*
 * Generate Download Button HTML.
 */
function html_for_asset_download_button($post_ID, $options = array())
{
    $download_access = get_post_meta($post_ID, 'download_access', true);

    if($download_access != 'allow_download')
        return '';

    $btn_classes = $wrap_classes = array();

    $label_text = esc_html__('Download', 'gowatch');

    $download_label = '<span class="entry-meta-description">' . $label_text . '</span>';

    if (!is_user_logged_in()) {
        $btn_classes[] = 'user-not-logged-in';
    }

    // prepare download link
    $s3_server_url = 'https://uploads-construkted.s3.us-east-2.amazonaws.com';

    global $post;

    $author_id = $post->post_author;
    $author_display_name = get_the_author_meta( 'display_name' , $author_id );
    $post_slug = $post->post_name;

    $original_3d_file_base_name = get_post_meta($post_ID, 'original_3d_file_base_name', true);

    $href = $s3_server_url . '/' . $author_display_name . '/' . $post_slug . '-' . $original_3d_file_base_name;

    return '<div class="airkit_add-to-favorite ' . implode(' ', $wrap_classes) . '"> 
                    <a class="btn-download ' . implode(' ', $btn_classes) . '" href="' . esc_url($href) . '" title="' . $label_text . '">
                        ' . $download_label . '
                    </a>
            </div>';
}

$construkted_admin = new CONSTRUKTED_Admin();
$construkted_admin->add_hooks();

add_action('after_setup_theme', function () {
    // remove parent theme 's default action.
    remove_filters_for_anonymous_class('tszf_render_pro_file_upload', 'TSZF_Pro_Loader', 'tszf_render_pro_file_upload_runner', 10);
});

/**
 * Allow to remove method for an hook when, it's a class method used and class don't have variable, but you know the class name :)
 */
function remove_filters_for_anonymous_class( $hook_name = '', $class_name = '', $method_name = '', $priority = 0 ) {
    global $wp_filter;
    // Take only filters on right hook name and priority
    if ( ! isset( $wp_filter[ $hook_name ][ $priority ] ) || ! is_array( $wp_filter[ $hook_name ][ $priority ] ) ) {
        return false;
    }
    // Loop on filters registered
    foreach ( (array) $wp_filter[ $hook_name ][ $priority ] as $unique_id => $filter_array ) {
        // Test if filter is an array ! (always for class/method)
        if ( isset( $filter_array['function'] ) && is_array( $filter_array['function'] ) ) {
            // Test if object is a class, class and method is equal to param !
            if ( is_object( $filter_array['function'][0] ) && get_class( $filter_array['function'][0] ) && get_class( $filter_array['function'][0] ) == $class_name && $filter_array['function'][1] == $method_name ) {
                // Test for WordPress >= 4.7 WP_Hook class (https://make.wordpress.org/core/2016/09/08/wp_hook-next-generation-actions-and-filters/)
                if ( is_a( $wp_filter[ $hook_name ], 'WP_Hook' ) ) {
                    unset( $wp_filter[ $hook_name ]->callbacks[ $priority ][ $unique_id ] );
                } else {
                    unset( $wp_filter[ $hook_name ][ $priority ][ $unique_id ] );
                }
            }
        }
    }
}