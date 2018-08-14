<?php
declare( strict_types = 1 );

# добавляет новый таг с постом в карту sitemap.xml
Route::post('sitemap/add-post/{post}', 'ApiController@addPostToSiteMap');
