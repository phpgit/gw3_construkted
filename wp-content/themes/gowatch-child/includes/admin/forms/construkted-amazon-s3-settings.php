<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Setting Page
 */

global $edd_cjs_model;

$model = $edd_cjs_model;

?>
<!-- . beginning of wrap -->
<div class="wrap">
     <form  method="post" action="options.php" enctype="multipart/form-data">
        <?php
            settings_fields( 'construkted_amazon_s3_options' );
            $amazon_s3_options = get_option( 'amazon_s3_options' );
        ?>

        <!-- beginning of the settings meta box -->
        <div id="edd-cjs-settings" class="post-box-container">
            <div class="metabox-holder">
                <div class="meta-box-sortables ui-sortable">
                    <div id="settings" class="postbox">
                        <div class="inside">
                            <table class="form-table wpd-ws-settings-box">
                                <tbody>
                                     <tr>
                                        <th scope="row">
                                            <label><strong><?php echo __( 'Amazon S3 Access Key ID:', 'edd_cjs' ) ?></strong></label>
                                        </th>
                                        <td>
                                            <input type="text" id="construkted-amazon-s3-access-key" name="amazon_s3_options[construkted-amazon-s3-access-key]" value="<?php echo !empty($amazon_s3_options['construkted-amazon-s3-access-key']) ? $amazon_s3_options['construkted-amazon-s3-access-key'] : '' ?>" size="63" /><br />
                                        </td>
                                     </tr>

                                     <tr>
                                         <th scope="row">
                                             <label><strong><?php echo __( 'Amazon S3 Secret Key:', 'edd_cjs' ) ?></strong></label>
                                         </th>
                                         <td>
                                             <input type="text" id="construkted-amazon-s3-secret-key" name="amazon_s3_options[construkted-amazon-s3-secret-key]" value="<?php echo !empty($amazon_s3_options['construkted-amazon-s3-secret-key']) ? $amazon_s3_options['construkted-amazon-s3-secret-key'] : '' ?>" size="63" /><br />
                                         </td>
                                     </tr>

                                     <tr>
                                         <th scope="row">
                                             <label><strong><?php echo __( 'Amazon S3 Bucket:', 'edd_cjs' ) ?></strong></label>
                                         </th>
                                         <td>
                                             <input type="text" id="construkted-amazon-s3-bucket" name="amazon_s3_options[construkted-amazon-s3-bucket]" value="<?php echo !empty($amazon_s3_options['construkted-amazon-s3-bucket']) ? $amazon_s3_options['construkted-amazon-s3-bucket'] : '' ?>" size="63" /><br />
                                         </td>
                                     </tr>

                                     <tr>
                                        <td colspan="2">
                                            <input type="submit" class="button-primary wpd-ws-settings-save" name="wpd_ws_settings_save" value="<?php echo __( 'Save Changes', 'edd_cjs' ) ?>" />
                                        </td>
                                    </tr>

                                </tbody>
                            </table>

                    </div><!-- .inside -->
                    </div><!-- #settings -->

                </div><!-- .meta-box-sortables ui-sortable -->

            </div><!-- .metabox-holder -->

        </div><!-- #wps-settings-general -->

    <!-- end of the settings meta box -->

    </form><!-- end of the plugin options form -->

</div><!-- .end of wrap -->