<?php

$command = 'php ';
$script_path = 'C:\xampp\htdocs\gw3.construkted.com\wp-content\themes\gowatch-child\includes\frontend-submission\class\start-upload-s3-tiling-request.php';


$post_id = 703;
$post_slug = "z6nh2za2cy";
$user_nice_name = "wugis1219";
$asset_model_type = "Polygon Mesh";
$asset_file_path = "C:\xampp\htdocs\gw3.construkted.com\wp-content\uploads/2020/01\coordinates-21.zip";
$s3_access_id = "AKIA5FBKWTGQ4HJGWY7P";
$s3_secret_key = "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";
$s3_bucket = "uploads-construkted";
$schema = "http";
$attachment_id = "702";

$command = $command . '"' . $script_path . '" ';
$command = $command . '"' . $post_id . '" ';
$command = $command . '"' . $post_slug . '" ';
$command = $command . '"' . $user_nice_name . '" ';
$command = $command . '"' . $asset_model_type . '" ';
$command = $command . '"' . $asset_file_path . '" ';
$command = $command . '"' . $s3_access_id . '" ';
$command = $command . '"' . $s3_secret_key . '" ';
$command = $command . '"' . $s3_bucket . '" ';
$command = $command . '"' . $schema . '" ';
$command = $command . '"' . $attachment_id . '"';

exec($command);
