<?php
/** @noinspection ForgottenDebugOutputInspection */
declare( strict_types = 1 );

# главная
Route::get('/', 'SiteController@index');

# посты по тагам
Route::get('/tag/{tag}', 'SiteController@showTagPage');

# автора
Route::get('/authors', 'SiteController@showAuthorsPage');

# автор и его статьи
Route::get('/authors/{author}', 'SiteController@showAuthorPostsPage');

# посты категории
Route::get('/{category}', 'SiteController@showCategoryPage');

# в случаи не соответствия категории основной категрии поста - 404
Route::group(['middleware' => ['postPage']], function () {
	# страница поста
	Route::get('/{category}/{post}', 'SiteController@showPostPage');
	# страница amp поста
	Route::get('/amp/{category}/{post}', 'SiteController@showAmpPostPage');
});

# посты по фильтрам (категория - таг)
Route::get('/filter/{category}/{tag}', 'SiteController@showCategoryTagsPage');
