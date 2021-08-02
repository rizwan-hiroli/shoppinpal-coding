<?php
date_default_timezone_set("Asia/Kolkata");
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/libs/mobile-detect.php');

$SITE_URL 			= 'https://'.$_SERVER['HTTP_HOST']; //for the services and other links
$SERVER_PATH 			= $_SERVER['DOCUMENT_ROOT']; //root directory.

$CDN_URL = ''; // Add CDN URL here to serve content
$CDN_URL = $SITE_URL; // comment this line when actual CDN URL is provided

$IMG_URL = $CDN_URL . '/images/';
$CSS_URL = $CDN_URL . '/css/';
$JS_URL = $CDN_URL . '/js/';
$VIDEO_URL = $CDN_URL . '/video/';
$API_URL = 'https://cms.samsunginfinitystage.com/api/';

$detect = new Mobile_Detect;
$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');

?>