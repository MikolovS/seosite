<?php
declare( strict_types = 1 );

include '../app/Library/Helpers/config.php';

$serverLink = getServeLink();

echo '
<pre>User-Agent: *
Disallow: /search
Sitemap: ' . $serverLink . '/sitemap.xml</pre>';