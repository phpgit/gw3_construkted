<?php

if (!defined('CONSTRUKTED_PATH')) {
    define('CONSTRUKTED_PATH', get_stylesheet_directory());
}

if (!defined('CS_LIB_VER')) {
    define('CS_LIB_VER', '1.0.0'); //library version of js and css
}

require(CONSTRUKTED_PATH . '/includes/functions.php');
require(CONSTRUKTED_PATH . '/includes/ajax.php');
require(CONSTRUKTED_PATH . '/includes/admin/admin.php');

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