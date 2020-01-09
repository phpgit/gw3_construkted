<?php
/**
 * Plugin Name: Construkted Settings
 * Plugin URI: http://www.construkted.com/
 * Description: Construkted Explore Customization Settings
 * Version: 1.0.0
 * Author: Construkted Team
 * Author URI: http://www.construkted.com/
 * Text Domain: 
 * Domain Path: languages
 *
 * @package Construkted Customize
 * @category Core
 * @author Construkted Team
 *
 * CHANGELOG
 * 1.0.0
 * - Initial Release
 *
 */

if( !defined( 'EDD_CJS_LIB_VER' ) ) {
    define( 'EDD_CJS_LIB_VER', '1.0.0' ); //library version of js and css
}

if( !defined( 'EDD_CJS_DIR' ) ) {
    define( 'EDD_CJS_DIR', dirname( __FILE__ ) ); // plugin dir
}

/**
 * Activation Hook
 */
register_activation_hook( __FILE__, 'construkted_setting_install' );

function construkted_setting_install() {

}

/**
 * Deactivation Hook
 */
register_deactivation_hook( __FILE__, 'construkted_setting_uninstall');

function construkted_setting_uninstall() {

}

// Model class handles most of model functionality of plugin
include_once( EDD_CJS_DIR .'/class-cjs-scripts.php' );

$edd_cjs_scripts = new EDD_CJS_Scripts();
$edd_cjs_scripts->add_hooks();

// ajax

add_action( 'wp_ajax_nopriv_get_post_data', 'get_post_data' );
add_action( 'wp_ajax_get_post_data', 'get_post_data');

function get_post_data() {
    $post_id = $_REQUEST['post_id'];

    $post_slug = get_post_field( 'post_name', $post_id );

    $data->post_slug = $post_slug;

    if($post->post_author != get_current_user_id())
        $data->is_owner = true;
    else
        $data->is_owner = false;

    $json = json_encode($data);

    echo $json;
}
