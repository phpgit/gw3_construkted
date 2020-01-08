<?php
/**
 * Plugin Name: construkted-setting
 * Plugin URI: http://www.construkted.com/
 * Description: EDD CesiumJS Customize
 * Version: 1.0.0
 * Author: Construkted Team
 * Author URI: http://www.construkted.com/
 * Text Domain: edd_cjs
 * Domain Path: languages
 *
 * @package EDD CesiumJS Customize
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
register_activation_hook( __FILE__, 'construked_setting_install' );

function construked_setting_install() {

}

/**
 * Deactivation Hook
 */
register_deactivation_hook( __FILE__, 'construked_setting_uninstall');

function construked_setting_uninstall() {

}

// Model class handles most of model functionality of plugin
include_once( EDD_CJS_DIR .'/class-cjs-scripts.php' );

$edd_cjs_scripts = new EDD_CJS_Scripts();
$edd_cjs_scripts->add_hooks();
