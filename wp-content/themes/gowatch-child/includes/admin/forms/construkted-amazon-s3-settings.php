<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Amazon S3 Settings Page
 */

?>
<!-- . beginning of wrap -->
<div class="wrap">
    <form  method="post" action="options.php" enctype="multipart/form-data">
        <?php
        settings_fields( 'construkted_amazon_s3_options' );
        $amazon_s3_options = get_option( 'amazon_s3_options' );
        ?>
        <div class="postbox">
            <div class="inside">
                <table class="form-table">
                    <tbody>
                    <tr>
                        <th scope="row">
                            <label><strong><?php echo __( 'Amazon S3 Access Key ID:', 'construkted' ) ?></strong></label>
                        </th>
                        <td>
                            <input type="text" id="construkted-amazon-s3-access-key" name="amazon_s3_options[construkted-amazon-s3-access-key]" value="<?php echo !empty($amazon_s3_options['construkted-amazon-s3-access-key']) ? $amazon_s3_options['construkted-amazon-s3-access-key'] : '' ?>" size="63" /><br />
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label><strong><?php echo __( 'Amazon S3 Secret Key:', 'construkted' ) ?></strong></label>
                        </th>
                        <td>
                            <input type="text" id="construkted-amazon-s3-secret-key" name="amazon_s3_options[construkted-amazon-s3-secret-key]" value="<?php echo !empty($amazon_s3_options['construkted-amazon-s3-secret-key']) ? $amazon_s3_options['construkted-amazon-s3-secret-key'] : '' ?>" size="63" /><br />
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label><strong><?php echo __( 'Amazon S3 Bucket:', 'construkted' ) ?></strong></label>
                        </th>
                        <td>
                            <input type="text" id="construkted-amazon-s3-bucket" name="amazon_s3_options[construkted-amazon-s3-bucket]" value="<?php echo !empty($amazon_s3_options['construkted-amazon-s3-bucket']) ? $amazon_s3_options['construkted-amazon-s3-bucket'] : '' ?>" size="63" /><br />
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="submit" class="button-primary" value="<?php echo __( 'Save Changes', 'construkted' ) ?>" />
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </form>
</div>