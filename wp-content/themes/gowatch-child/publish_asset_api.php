<?php

/**
 * Template Name: Publish Asset API
 *
 */

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
header('Access-Control-Allow-Headers: Content-Type');
header("Access-Control-Allow-Origin: *");

require_once ABSPATH . '/wp-admin/includes/image.php';

// http://localhost/gw3.construkted.com/publish-asset-api/?post_id=647

if(isset($_REQUEST['post_id'])) {
    $post_id = $_REQUEST['post_id'];
    $attachment_id = $_REQUEST['orig_asset_attachment_id'];

    if($attachment_id == null) {
        echo json_encode(array('errCode' => 1, 'errMsg' => 'orig_asset_attachment_id!'));
        exit;
    }

    if ( !get_post ( $post_id ) ) {
        echo json_encode(array('errCode' => 1, 'errMsg' => 'specified post ' . $post_id . ' does not exist!'));
        exit;
    }

    $attached_file = get_attached_file($attachment_id, false);

    wp_delete_attachment( $attachment_id, true );

    // we save original file name for making download link

    add_post_meta($post_id, 'original_3d_file_base_name', basename($attached_file));

    wp_publish_post($post_id);

    // update thumbnail
    $post = get_post($post_id);
    $slug = $post->post_name;

    $thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );

    // check old thumbnail and delete
    if($thumbnail_id != "")
        if( ! wp_delete_attachment( $thumbnail_id, true )) {
            echo json_encode(array('errCode' => 0, 'errMsg' => 'failed to delete old thumbnail!'));
            exit;
        }

    set_default_thumbnail_of_no_thumbnail($post_id, $slug);

    echo json_encode(array('errCode' => 0, 'errMsg' => 'successfully published!'));
    exit;
}
else {
    echo json_encode(array('errCode' => 1, 'errMsg' => 'please specify post id!'));
    exit;
}

function set_default_thumbnail_of_no_thumbnail($post_id, $slug) {
    $thumbnailFileName = 'thumbnail_' . $slug . '.png';
    $wordpress_upload_dir = wp_upload_dir();
    $thumbnail_file_path = $wordpress_upload_dir['path'] . '/' . $thumbnailFileName;
    $orig_thumbnail_file_path = get_stylesheet_directory() . '/images/default_image-noThumbnail-flat.png';

    $ret = copy($orig_thumbnail_file_path, $thumbnail_file_path);

    if($ret == false)
        wp_die('failed to copy image');

    $attachment = array(
        'post_author' => 1,
        'post_date' => current_time('mysql'),
        'post_date_gmt' => current_time('mysql'),
        'post_title' => preg_replace( '/\.[^.]+$/', '', basename(  $thumbnail_file_path) ),
        'post_status' => 'inherit',
        'comment_status' => 'open',
        'ping_status' => 'closed',
        'post_name' => sanitize_title_with_dashes(str_replace("_", "-", $thumbnail_file_path)),
        'post_modified' => current_time('mysql'),
        'post_modified_gmt' => current_time('mysql'),
        'post_parent' => $post_id,
        'post_type' => 'attachment',
        'guid' => $thumbnail_file_path,
        'post_mime_type' => 'image/png',
        'post_excerpt' => '',
        'post_content' => ''
    );

    //insert the database record
    $attachment_id = wp_insert_attachment( $attachment, $thumbnail_file_path, $post_id );

    if($attachment_id == 0) {
        wp_die('failed to insert attachment!');
    }

    $attachment_meta_data = wp_generate_attachment_metadata( $attachment_id, $thumbnail_file_path);

    wp_update_attachment_metadata($attachment_id, $attachment_meta_data);

    $ret = update_post_meta( $post_id, '_thumbnail_id', $attachment_id );

    if($ret == false)
        wp_die('failed to update post meta!');
}