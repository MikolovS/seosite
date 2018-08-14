<?php
declare( strict_types = 1 );

include '../app/Library/Helpers/config.php';

function sendResponse ()
{
	$host = parse_url(getServeLink())[ 'host' ];

	$folder = convertDomain($host);

	$sitemap = @file_get_contents('sitemaps/' . $folder . '/sitemap.xml');

	if ($sitemap) {
		header('Content-type: text/xml;charset=utf-8');
		echo $sitemap;
	}
	else {
		header('HTTP/1.0 404 Not Found');
		echo '<h1>404 File not found</h1>';
	}
}

sendResponse();