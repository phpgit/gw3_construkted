<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Scripts Class
 *
 * Handles adding scripts functionality to the admin pages
 * as well as the front pages.
 *
 * @package EDD CesiumJS Customize
 * @since 1.0.0
 */
class EDD_CJS_Scripts {

    public function __construct() {

    }

    /**
     * Adding Scripts
     *
     * Adding Scripts for check code public
     */
    public function enqueue_scripts_and_styles(){
        // add cesium cdn js and css
        wp_enqueue_style( 'edd-cjs-cesium-widgets-style',  'https://cesiumjs.org/releases/1.65/Build/Cesium/Widgets/widgets.css', array(), EDD_CJS_LIB_VER );
        wp_enqueue_script('edd-cjs-cesium-script', 'https://cesiumjs.org/releases/1.65/Build/Cesium/Cesium.js', array('jquery'), EDD_CJS_LIB_VER, true);

        $css_dir = '/wp-content/plugins/construked-setting/css/';

        wp_enqueue_style(
            'construkted-setting', $css_dir . 'construkted-setting.css'
        );

        $script_dir = '/wp-content/plugins/construked-setting/js/';

        wp_enqueue_script('cesium-ion-sdk-plugin-script',  $script_dir . 'CesiumIonSDKPlugin.js', array('jquery', 'edd-cjs-cesium-script'), EDD_CJS_LIB_VER, true);
        wp_enqueue_script('edd-cjs-camera-controller-script',  $script_dir . 'edd-cjs-camera-controller.js', array('jquery', 'edd-cjs-cesium-script'), EDD_CJS_LIB_VER, true);
        wp_enqueue_script('edd-cjs-3dtileset-location-editor-script', $script_dir . 'edd-cjs-3dtileset-location-editor.js', array('jquery', 'edd-cjs-cesium-script'), EDD_CJS_LIB_VER, true);
        wp_enqueue_script('edd-cjs-measurer-script', $script_dir . 'edd-cjs-measurer.js', array('jquery', 'edd-cjs-cesium-script'), EDD_CJS_LIB_VER, true);
        wp_enqueue_script('edd-cjs-clipping-tool-script', $script_dir . 'CesiumClippingTool.js', array('jquery', 'edd-cjs-cesium-script'), EDD_CJS_LIB_VER, true);

        wp_register_script('edd-cjs-public-script', $script_dir . 'edd-cjs-public-script.js',
            array('jquery',
                'cesium-ion-sdk-plugin-script',
                'edd-cjs-camera-controller-script',
                'edd-cjs-3dtileset-location-editor-script',
                'edd-cjs-measurer-script',
                'edd-cjs-clipping-tool-script',
                'edd-cjs-cesium-script'), EDD_CJS_LIB_VER, true);

        wp_enqueue_script('edd-cjs-public-script');

        global $post;

        $post_id = $post->ID;

        // pass parameter to edd-cjs-public-script.js
        wp_localize_script( 'edd-cjs-public-script', 'EDD_CJS_PUBLIC_AJAX',
            array(
                'ajaxurl' => admin_url( 'admin-ajax.php' ),
                'post_id' => $post_id
            )
        );
    }

    /**
     * Adding Hooks
     *
     * @package EDD CesiumJS Customize
     * @since 1.0.0
     */
    public function add_hooks() {
        //add scripts for fronted side

        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts_and_styles' ));
    }
}
