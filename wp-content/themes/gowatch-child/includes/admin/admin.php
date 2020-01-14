<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Public Class
 *
 * Manage Public Class

 */
class CONSTRUKTED_Admin {
    //class constructor
    function __construct() {
    }

    /**
     * Initialize settings api.
     */
    public function construkted_admin_init() {
        register_setting( 'construkted_amazon_s3_options', 'amazon_s3_options', array($this, '') );
    }

    /**
     * Create option page admin menu for frontend submission customization.
     */
    public function construkted_admin_menu() {
        add_options_page(
            'Construkted',
            'Construkted',
            'manage_options',
            'construkted_page',
            array($this,'edd_cjs_construkted_settings_page')
        );
    }

    /**
     * Create option page admin menu for tabbing set.
     */
    public function edd_cjs_construkted_settings_page() {
        ?>

        <h2 class="nav-tab-wrapper">
            <?php
            do_action( 'construkted_settings_tab' );
            ?>
        </h2>
        <?php
        do_action( 'construkted_settings_content' );
    }

    /**
     * Create option page admin menu for tabbing.
     */
    public function construkted_settings_tab(){
        ?>
        <a class="nav-tab " href="<?php echo admin_url( 'options-general.php?page=construkted_page' ); ?>">
            <?php _e( 'Amazon S3 Settings', 'edd_cjs' ); ?>
        </a>
        <?php
    }

    /**
     * Create option page admin menu for tabbing content.
     */
    public function construkted_settings_content() {
        require_once( CONSTRUKTED_PATH . '/includes/admin/forms/construkted-amazon-s3-settings.php' );
    }

    /**
     * Adding Hooks
     */
    function add_hooks() {
        // Add settings option
        add_action( 'admin_init', array( $this, 'construkted_admin_init' ), 50, 1 );

        /*Settings in create option menu*/

        add_action( 'admin_menu', array( $this, 'construkted_admin_menu' ) );
        add_action( 'construkted_settings_tab', array( $this, 'construkted_settings_tab' ) );
        add_action( 'construkted_settings_content', array( $this, 'construkted_settings_content' ) );
    }
}
