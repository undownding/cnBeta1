<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/** ------------------------------------------
 *  Route model binding
 *  ------------------------------------------
 */
Route::model('user', 'User');
Route::model('comment', 'Comment');
Route::model('post', 'Post');
Route::model('role', 'Role');

/** ------------------------------------------
 *  Route constraint patterns
 *  ------------------------------------------
 */
Route::pattern('article', '[0-9]+');
Route::pattern('comment', '[0-9]+');
Route::pattern('post', '[0-9]+');
Route::pattern('user', '[0-9]+');
Route::pattern('role', '[0-9]+');
Route::pattern('token', '[0-9a-z]+');

/** ------------------------------------------
 *  Admin Routes
 *  ------------------------------------------
 */
Route::group(array('prefix' => 'admin', 'before' => 'auth'), function()
{

    # Comment Management
    Route::get('comments/{comment}/edit', 'AdminCommentsController@getEdit');
    Route::post('comments/{comment}/edit', 'AdminCommentsController@postEdit');
    Route::get('comments/{comment}/delete', 'AdminCommentsController@getDelete');
    Route::post('comments/{comment}/delete', 'AdminCommentsController@postDelete');
    Route::controller('comments', 'AdminCommentsController');

    # Blog Management
    Route::get('blogs/{post}/show', 'AdminBlogsController@getShow');
    Route::get('blogs/{post}/edit', 'AdminBlogsController@getEdit');
    Route::post('blogs/{post}/edit', 'AdminBlogsController@postEdit');
    Route::get('blogs/{post}/delete', 'AdminBlogsController@getDelete');
    Route::post('blogs/{post}/delete', 'AdminBlogsController@postDelete');
    Route::controller('blogs', 'AdminBlogsController');

    # User Management
    Route::get('users/{user}/show', 'AdminUsersController@getShow');
    Route::get('users/{user}/edit', 'AdminUsersController@getEdit');
    Route::post('users/{user}/edit', 'AdminUsersController@postEdit');
    Route::get('users/{user}/delete', 'AdminUsersController@getDelete');
    Route::post('users/{user}/delete', 'AdminUsersController@postDelete');
    Route::controller('users', 'AdminUsersController');

    # User Role Management
    Route::get('roles/{role}/show', 'AdminRolesController@getShow');
    Route::get('roles/{role}/edit', 'AdminRolesController@getEdit');
    Route::post('roles/{role}/edit', 'AdminRolesController@postEdit');
    Route::get('roles/{role}/delete', 'AdminRolesController@getDelete');
    Route::post('roles/{role}/delete', 'AdminRolesController@postDelete');
    Route::controller('roles', 'AdminRolesController');

    # Admin Dashboard
    Route::controller('/', 'AdminDashboardController');
});


/** ------------------------------------------
 *  Frontend Routes
 *  ------------------------------------------
 */

// User reset routes
Route::get('user/reset/{token}', 'UserController@getReset');
// User password reset
Route::post('user/reset/{token}', 'UserController@postReset');
//:: User Account Routes ::
Route::post('user/{user}/edit', 'UserController@postEdit');

//:: User Account Routes ::
Route::post('user/login', 'UserController@postLogin');

# User RESTful Routes (Login, Logout, Register, etc)
Route::controller('user', 'UserController');

//:: Application Routes ::
Route::get('usage', function()
{
    return View::make('site/usage');
});
Route::get('about', function()
{
    return View::make('site/about');
});
Route::get('api', function()
{
    return View::make('site/api');
});
Route::get('donate', function()
{
    return View::make('site/donate');
});
Route::get('robot', function()
{
    return View::make('site/robot');
});

# Posts - Second to last set, match slug
#Route::get('{postSlug}', 'BlogController@getView');
#Route::post('{postSlug}', 'BlogController@postView');
Route::get('blog/{postSlug}', 'BlogController@getView');
Route::post('blog/{postSlug}', 'BlogController@postView');

# Articles
Route::get('{article}', 'ArticleController@showArticle');
Route::get('articles/{article}.htm', function($article) {
    return Redirect::to($article);
});

# API
Route::get('api/getArticles', 'APIController@getArticles');
Route::get('api/getMoreArticles/{article}', 'APIController@getMoreArticles');
Route::get('api/getArticleDetail/{article}', 'APIController@getArticleDetail');
Route::get('api/syncArticleDetail/{article}', 'APIController@syncArticleDetail');

# Feed
Route::get('feed', 'APIController@getFeed');

# Sync
Route::get('sync', 'APIController@sync');

# Index Page - Last route, no matches
#Route::get('/', array('before' => 'detectLang','uses' => 'BlogController@getIndex'));
Route::get('/blog', array('before' => 'detectLang','uses' => 'BlogController@getIndex'));
Route::get('/', 'ArticleController@getIndex');

# pac generator
Route::get('/pac', function() {
    return View::make('site/pac/index');
});
Route::get('/pac/{host}_{port}.pac', function($host, $port) {
    return View::make('site/pac/pac', array('type' => 'PROXY', 'host' => $host, 'port' => $port));
});
Route::get('/pac/{type}_{host}_{port}.pac', function($type, $host, $port) {
    return View::make('site/pac/pac', array('type' => strtoupper($type), 'host' => $host, 'port' => $port));
});
