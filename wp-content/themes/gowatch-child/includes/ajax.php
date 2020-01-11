<?php

add_action( 'wp_ajax_nopriv_post_set_thumbnail', 'post_set_thumbnail' );
add_action( 'wp_ajax_post_set_thumbnail', 'post_set_thumbnail' );

function post_set_thumbnail() {
    $post_id = $_REQUEST['post_id'];
    $thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );

    // check old thumbnail and delete
    if($thumbnail_id != "")
        if( ! wp_delete_attachment( $thumbnail_id, true )) {
            echo "failed to delete old thumbnail!";
            return;
        }

    // save image

    $image = $_REQUEST['capturedJpegImage'];
    $image = str_replace('data:image/jpeg;base64,', '', $image);
    $image = str_replace(' ', '+', $image);
    $imageData = base64_decode($image);

    $thumbnailFileName = 'thumbnail' . time().'.jpg';

    $wordpress_upload_dir = wp_upload_dir();

    $new_file_path = $wordpress_upload_dir['path'] . '/' . $thumbnailFileName;

    file_put_contents($new_file_path, $imageData);

    // end save image

    // insert new attachment

    $siteurl = get_option('siteurl');

    $artdata = array();

    $artdata = array(
        'post_author' => 1,
        'post_date' => current_time('mysql'),
        'post_date_gmt' => current_time('mysql'),
        'post_title' => $thumbnailFileName,
        'post_status' => 'inherit',
        'comment_status' => 'open',
        'ping_status' => 'closed',
        'post_name' => sanitize_title_with_dashes(str_replace("_", "-", $thumbnailFileName)),
        'post_modified' => current_time('mysql'),
        'post_modified_gmt' => current_time('mysql'),
        'post_parent' => $post_id,
        'post_type' => 'attachment',
        'guid' => $siteurl.'/'. $new_file_path,
        'post_mime_type' => 'image/jpeg',
        'post_excerpt' => '',
        'post_content' => ''
    );

    //insert the database record
    $attach_id = wp_insert_attachment( $artdata, $new_file_path, $post_id );

    if($attach_id == 0) {
        echo 'failed to insert attach!';
        return;
    }

    //generate metadata and thumbnails
    if ($attach_data = wp_generate_attachment_metadata( $attach_id, $new_file_path)) {
        wp_update_attachment_metadata($attach_id, $attach_data);
    }
    else {

    }

    $ret = update_post_meta( $post_id, '_thumbnail_id', $attach_id );

    if($ret == true) {
        echo "successfully update thumbnail!";
    }
    else {
        echo "failed to update thumbnail!";
    }

    wp_die();
}

add_action( 'wp_ajax_nopriv_post_set_current_view', 'post_set_current_view' );
add_action( 'wp_ajax_post_set_current_view', 'post_set_current_view' );

function post_set_current_view() {
    $post_id = $_REQUEST['post_id'];
    $view_data = $_REQUEST['view_data'];

    $ret = update_post_meta( $post_id, 'default_camera_position_direction', $view_data );

    if($ret == true)
        echo "successfully updated!";
    else {
        echo "failed to updated!";
    }

    wp_die();
}

add_action( 'wp_ajax_nopriv_post_reset_current_view', 'post_reset_current_view' );
add_action( 'wp_ajax_post_reset_current_view', 'post_reset_current_view' );

function post_reset_current_view() {
    $post_id = $_REQUEST['post_id'];

    $ret = update_post_meta( $post_id, 'default_camera_position_direction', '' );

    if($ret == true)
        echo "successfully updated!";
    else {
        echo "failed to updated!";
    }

    wp_die();
}