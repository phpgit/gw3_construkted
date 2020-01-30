<?php

function save_thumbnail_from_request($post_id) {
    $image = $_REQUEST['capturedJpegImage'];
    $image = str_replace('data:image/jpeg;base64,', '', $image);
    $image = str_replace(' ', '+', $image);
    $imageData = base64_decode($image);

    $post = get_post($post_id);
    $slug = $post->post_name;
    $thumbnailFileName = 'thumbnail_' . $slug . '.jpg';

    $wordpress_upload_dir = wp_upload_dir();

    $file_path = $wordpress_upload_dir['path'] . '/' . $thumbnailFileName;

    file_put_contents($file_path, $imageData);

    return $file_path;
}

function do_set_thumbnail($post_id, $thumbnail_file_path) {
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
        'post_mime_type' => 'image/jpeg',
        'post_excerpt' => '',
        'post_content' => ''
    );

    //insert the database record
    $attachment_id = wp_insert_attachment( $attachment, $thumbnail_file_path, $post_id );

    if($attachment_id == 0) {
        return array(
            'success' => false,
            'message' => 'failed to insert attachment!!'
        );
    }

    $attachment_meta_data = wp_generate_attachment_metadata( $attachment_id, $thumbnail_file_path);

    wp_update_attachment_metadata($attachment_id, $attachment_meta_data);

    $ret = update_post_meta( $post_id, '_thumbnail_id', $attachment_id );

    if($ret == true)
        return array(
            'success' => true,
            'message' => 'successfully update thumbnail!'
        );
    else
        return array(
            'success' => false,
            'message' => 'failed to update post meta!'
        );
}

function set_thumbnail_from_request($post_id) {
    $thumbnail_file_path = save_thumbnail_from_request($post_id);
    $ret = do_set_thumbnail($post_id, $thumbnail_file_path);

    echo $ret['message'];

    wp_die();
}

add_action( 'wp_ajax_nopriv_post_set_thumbnail', 'post_set_thumbnail' );
add_action( 'wp_ajax_post_set_thumbnail', 'post_set_thumbnail' );

function post_set_thumbnail() {
    $post_id = $_REQUEST['post_id'];
    $thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );

    // check old thumbnail and delete
    if($thumbnail_id != "")
        if( ! wp_delete_attachment( $thumbnail_id, true )) {
            echo "failed to delete old thumbnail!";
            wp_die();
        }

    set_thumbnail_from_request($post_id);
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