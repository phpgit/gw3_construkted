<?php

if ($argc != 11)
{
    echo 'invalid argument count : ' . $argc . "\n";
    exit();
}

$post_id = $argv[1];
$post_slug = $argv[2];
$user_nice_name = $argv[3];
$asset_model_type = $argv[4];
$asset_file_path = $argv[5];
$s3_access_id = $argv[6];
$s3_secret_key = $argv[7];
$s3_bucket = $argv[8];
$schema = $argv[9];
$attachment_id = $argv[10];

echo 'post_id : ' . $post_id . "\n";
echo 'post_slug : ' . $post_slug . "\n";
echo 'user_nice_name : ' . $user_nice_name . "\n";
echo 'asset_model_type : ' . $asset_model_type . "\n";
echo 'asset_file_path : ' . $asset_file_path . "\n";
echo 's3_access_id : ' . $s3_access_id . "\n";
echo 's3_secret_key : ' . $s3_secret_key . "\n";
echo 's3_bucket : ' . $s3_bucket . "\n";
echo 'schema : ' . $schema . "\n";
echo 'attachment_id : ' . $attachment_id . "\n";

function my_untrailingslashit( $string ) {
    return rtrim( $string, '/\\' );
}

function my_trailingslashit( $string ) {
    return my_untrailingslashit( $string ) . '/';
}

$folder = my_trailingslashit( $user_nice_name );
$file_name = $post_slug  . '-' . basename($asset_file_path);

require dirname( __FILE__ ) . '/amazon-s3/vendor/autoload.php';

$s3 = new Aws\S3\S3MultiRegionClient( array(
    'version'           => '2006-03-01',
    'credentials'       => array(
        'key'    => $s3_access_id,
        'secret' => $s3_secret_key,
    ),
    'signature_version' => 'v4',
    'scheme'            => $schema
) );

try {
    $s3->putObject( array(
        'Bucket'     => $s3_bucket,
        'Key'        => $folder . $file_name,
        'SourceFile' => $asset_file_path,
    ) );
} catch ( S3Exception $e ) {
    echo $e->getAwsErrorMessage();
    exit;
}

$server_url = 'http://18.189.185.13:5000/request_tiling';

$url = $server_url . '/?' .
       'postId=' . $post_id .
       '&slug=' . $post_slug .
       '&userName=' . $user_nice_name .
       '&fileName=' . $file_name .
       '&assetModelType=' . $asset_model_type .
       '&attachmentId=' . $attachment_id;

$url = str_replace(" ", "%20", $url);

$ret = file_get_contents($url, False);

if($ret == false) {
    echo 'failed to get response from edd tiling server!';
    exit;
}

$ret = json_decode($ret);

if($ret->errCode != 0) {
    echo "error code : " . $ret->errCode . "\n";
    return;
}

echo 'ok';






