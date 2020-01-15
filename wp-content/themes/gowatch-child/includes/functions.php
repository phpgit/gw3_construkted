<?php

function enqueue_scripts_and_styles(){
    // add cesiumjs cdn js and css

    define('CESIUMJS_VER', '1.65');

    wp_enqueue_style( 'cesiumjs-style',  'https://cesiumjs.org/releases/' . CESIUMJS_VER . '/Build/Cesium/Widgets/widgets.css', array(), CESIUMJS_VER );
    wp_enqueue_script('cesiumjs', 'https://cesiumjs.org/releases/' . CESIUMJS_VER .'/Build/Cesium/Cesium.js', array('jquery'), CESIUMJS_VER, true);

    $css_dir = '/wp-content/themes/gowatch-child/css/';

    wp_enqueue_style(
        'construkted-css', $css_dir . 'construkted.css'
    );

    $script_dir = '/wp-content/themes/gowatch-child/js/';;

    wp_enqueue_script('cesium-ion-sdk-plugin-script',  $script_dir . 'cesium-ion-sdk-plugin.js', array('jquery', 'cesiumjs'), CS_LIB_VER, true);
    wp_enqueue_script('cs-camera-controller-script',  $script_dir . 'cs-camera-controller.js', array('jquery', 'cesiumjs'), CS_LIB_VER, true);

    // frontend starting point
    wp_register_script('construkted-script', $script_dir . 'construkted.js',
        array('jquery',
            'cesiumjs',
            'cesium-ion-sdk-plugin-script',
            'cs-camera-controller-script'
        ), CS_LIB_VER, true);

    wp_enqueue_script('construkted-script');

    global $post;

    $post_id = $post->ID;

    $post_slug = get_post_field( 'post_name', $post_id );
    $default_camera_position_direction = get_post_meta( $post_id, 'default_camera_position_direction', true);

    // pass parameter to starting script: construkted-scrip.js
    wp_localize_script( 'construkted-script', 'CONSTRUKTED_AJAX',
        array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'post_id' => $post_id,
            'post_slug' => $post_slug,
            'default_camera_position_direction' => $default_camera_position_direction
        )
    );
}

function construkted_cesium_viewer() {
    echo '<div id="cesiumContainer"></div>';
    echo '<div id="toolbar" ><button id="exitFPVModeButton" style="display: none" class="cesium-button">EXIT FPV MODE</button></div>';

    global $post;

    if($post->post_author == get_current_user_id()) {
        echo '<button id="capture_thumbnail" class="cesium-button">Capture Thumbnail</button>';
        echo '<button id="save_current_view" class="cesium-button">Save Current View</button>';
        echo '<button id="reset_camera_view" class="cesium-button">Reset Camera View</button>';
    }

    enqueue_scripts_and_styles();
}