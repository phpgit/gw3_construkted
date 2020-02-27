<?php 
$menu_bar_root=get_stylesheet_directory_uri() . '/side-menu-bar/';
$assets_root=$menu_bar_root . 'assets/';
$icons_root=$menu_bar_root . 'assets/icons/';
$loadscript_root=$menu_bar_root . 'data/';
$popup_top='120px';

$items['layers']=[
    'title'=>'Layers',
    'tooltip'=>'Layers of hover tips',
    'icon'=>'layers.png',
    'icon_hl'=>'layers_hl.png',
    'width'=>'300px',
    'height'=>'150px',
    'top'=>$popup_top,
    'loadscript'=>'layers.php',
    'disabled'=>'',// disabled
];
$items['geo']=[
    'title'=>'Geo-Location',
    'tooltip'=>'Geo-Location of hover tips',
    'icon'=>'geo.png',
    'icon_hl'=>'geo_hl.png',
    'width'=>'300px',
    'height'=>'150px',
    'top'=>$popup_top,
    'loadscript'=>'geo.php',
    'disabled'=>'',// disabled
];
$items['measurements']=[
    'title'=>'Measurements',
    'tooltip'=>'Measurements of hover tips',
    'icon'=>'measurements.png',
    'icon_hl'=>'measurements_hl.png',
    'width'=>'300px',
    'height'=>'150px',
    'top'=>$popup_top,
    'loadscript'=>'measurements.php',
    'disabled'=>'',// disabled
];
$items['settings']=[
    'title'=>'Settings',
    'tooltip'=>'Settings of hover tips',
    'icon'=>'settings.png',
    'icon_hl'=>'settings_hl.png',
    'width'=>'300px',
    'height'=>'150px',
    'top'=>$popup_top,
    'loadscript'=>'settings.php',
    'disabled'=>'',// disabled
];
?>
<?php 
  require_once __DIR__ . '/templates/side-menu-bar.php';
?>
