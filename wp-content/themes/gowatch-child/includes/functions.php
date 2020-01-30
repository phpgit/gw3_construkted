<?php

function enqueue_scripts_and_styles_for_asset_view(){
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
            'default_camera_position_direction' => $default_camera_position_direction,
            'tile_server_url' => CONSTRUKTED_3D_TILE_SERVER_URL
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

    enqueue_scripts_and_styles_for_asset_view();
}

// byte
function getTotalUploadedFileSizeOfCurrentUser() {
    global $current_user;

    $args = array(
        'author'        =>  $current_user->ID,
        'post_status' => 'any',
        'post_type' => 'video',
        'orderby'       =>  'post_date',
        'order'         =>  'ASC',
        'posts_per_page' => -1 // no limit
    );

    $current_user_posts = get_posts( $args );

    $total = 0;

    foreach ($current_user_posts as $post) {
        $post_id = $post->ID;

        $uploaded_file_size = get_post_meta( $post_id, 'uploaded_file_size', true);

        if($uploaded_file_size == '')
            continue;

        $total += (float)$uploaded_file_size;
    }

    return $total;

}

// GB format
function getTotalUploadedFileGBSizeOfCurrentUser() {
    $total = getTotalUploadedFileSizeOfCurrentUser();

    $total = $total / (1024*1024*1024) ;

    return number_format($total, 2);
}

// GB format

function getDiskQuotaOfCurrentUser() {
    $current_user = wp_get_current_user();

    if ( $current_user->ID == 0) {
        return 0;
    }

    // get user orders (COMPLETED + PROCESSING)
    $customer_orders = get_posts( array(
        'numberposts' => -1,
        'meta_key'    => '_customer_user',
        'meta_value'  => $current_user->ID,
        'post_type'   => wc_get_order_types(),
        'post_status' => array_keys( wc_get_is_paid_statuses() ),
    ) );

    // LOOP THROUGH ORDERS AND GET PRODUCT IDS
    if ( ! $customer_orders )
        return DEFAULT_DISK_QUOTA;

    $product_ids = array();

    foreach ( $customer_orders as $customer_order ) {
        $order = wc_get_order( $customer_order->ID );
        $items = $order->get_items();

        foreach ( $items as $item ) {
            $product_id = $item->get_product_id();
            $product_ids[] = $product_id;
        }
    }

    $product_ids = array_unique( $product_ids );

    for ($i = 0; $i < count($product_ids); $i++) {
        $product = wc_get_product($product_ids[$i]);

        $sku = $product->get_sku();

        if (strpos($sku, 'disk_quota;') === false) {
            continue;
        }

        $pieces = explode(";", $sku);

        if(count($pieces) < 2)
            continue;

        $disk_quota = $pieces[1];

        return intval($disk_quota);
    }

    return DEFAULT_DISK_QUOTA;
}