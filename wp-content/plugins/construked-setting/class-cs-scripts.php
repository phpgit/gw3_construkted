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
class CS_Scripts {

    public function __construct() {

    }

    /**
     * Adding Scripts
     *
     * Adding Scripts for check code public
     */
    public function enqueue_scripts_and_styles(){
        // add cesiumjs cdn js and css

        define('CESIUMJS_VER', '1.65');

        wp_enqueue_style( 'cesiumjs-style',  'https://cesiumjs.org/releases/' . CESIUMJS_VER . '/Build/Cesium/Widgets/widgets.css', array(), CESIUMJS_VER );
        wp_enqueue_script('cesiumjs', 'https://cesiumjs.org/releases/' . CESIUMJS_VER .'/Build/Cesium/Cesium.js', array('jquery'), CESIUMJS_VER, true);

        $css_dir = '/wp-content/plugins/construked-setting/css/';

        wp_enqueue_style(
            'construkted-setting', $css_dir . 'construkted-setting.css'
        );

        $script_dir = '/wp-content/plugins/construked-setting/js/';

        wp_enqueue_script('cesium-ion-sdk-plugin-script',  $script_dir . 'cesium-ion-sdk-plugin.js', array('jquery', 'cesiumjs'), CS_LIB_VER, true);
        wp_enqueue_script('cs-camera-controller-script',  $script_dir . 'cs-camera-controller.js', array('jquery', 'cesiumjs'), CS_LIB_VER, true);

        // frontend starting point
        wp_register_script('construkted-setting-script', $script_dir . 'construkted-setting.js',
            array('jquery',
                'cesiumjs',
                'cesium-ion-sdk-plugin-script',
                'cs-camera-controller-script'
                ), CS_LIB_VER, true);

        wp_enqueue_script('construkted-setting-script');

        global $post;

        $post_id = $post->ID;

        // pass parameter to starting script: construkted-setting-scrip.js
        wp_localize_script( 'construkted-setting-script', 'EDD_CJS_PUBLIC_AJAX',
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
