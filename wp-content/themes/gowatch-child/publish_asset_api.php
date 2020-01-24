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

// http://localhost/gw3.construkted.com/publish-asset-api/?post_id=647

if(isset($_REQUEST['post_id'])) {
    $post_id = $_REQUEST['post_id'];
    $attachment_id = $_REQUEST['attachment_id'];

    if ( !get_post ( $post_id ) ) {
        echo json_encode(array('errCode' => 1, 'errMsg' => 'specified post ' . $post_id . ' does not exist!'));
        exit;
    }

    $attached_file = get_attached_file($attachment_id, false);

    wp_delete_attachment( $attachment_id, true );

    // we save original file name for making download link

    add_post_meta($post_id, 'original_3d_file_base_name', basename($attached_file));

    wp_publish_post($post_id);

    echo json_encode(array('errCode' => 0, 'errMsg' => 'successfully published!'));
    exit;
}
else {
    $url = site_url() . '/';

    echo json_encode(array('errCode' => 1, 'errMsg' => 'please specify post id!'));
    exit;
}
