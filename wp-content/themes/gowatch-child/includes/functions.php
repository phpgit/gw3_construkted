<?php

add_action( 'wp_enqueue_scripts', 'gowatch_child_enqueue_styles' );

function gowatch_child_enqueue_styles() {
    wp_enqueue_style( 'gowatch-child-style', get_stylesheet_directory_uri() . '/style.css', array('gowatch-style','gowatch-bootstrap'));
}
// Post Meta

/*
 * Generate Download Button HTML.
 */
function asset_download_button( $post_ID, $options = array() )
{
    $btn_classes 	= $wrap_classes = array();
    $ajax_nonce 	= wp_create_nonce( 'ajax_airkit_add_to_favorite' );

    $label_text  	= esc_html__( 'Download', 'gowatch' );

    $download_label = '<span class="entry-meta-description">' . $label_text . '</span>';

    if ( !is_user_logged_in() ) {
        $href = 'download_link';
        $btn_classes[] = 'user-not-logged-in';
    }

    return '<div class="airkit_add-to-favorite '. implode( ' ', $wrap_classes ) .'">
                    <a class="btn-add-to-favorite '. implode( ' ', $btn_classes ) .'" href="'. esc_url( $href ) .'" title="'. $label_text .'" data-post-id="'. $post_ID .'" data-ajax-nonce="'. $ajax_nonce .'">
                        ' . $download_label . '
                    </a>
            </div>';
}

add_action( 'after_setup_theme', 'asset_download_button' );


?>