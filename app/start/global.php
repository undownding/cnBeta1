<?php

/*
  |--------------------------------------------------------------------------
  | Register The Laravel Class Loader
  |--------------------------------------------------------------------------
  |
  | In addition to using Composer, you may use the Laravel class loader to
  | load your controllers and models. This is useful for keeping all of
  | your classes in the "global" namespace without Composer updating.
  |
 */

ClassLoader::addDirectories(array(
    app_path() . '/cache',
    app_path() . '/commands',
    app_path() . '/controllers',
    app_path() . '/models',
    app_path() . '/database/seeds',
));

/*
  |--------------------------------------------------------------------------
  | Application Error Logger
  |--------------------------------------------------------------------------
  |
  | Here we will configure the error logger setup for the application which
  | is built on top of the wonderful Monolog library. By default we will
  | build a rotating log file setup which creates a new file each day.
  |
 */

$logFile = 'log-' . php_sapi_name() . '.txt';

Log::useDailyFiles(storage_path() . '/logs/' . $logFile);

/*
  |--------------------------------------------------------------------------
  | Application Error Handler
  |--------------------------------------------------------------------------
  |
  | Here you may handle any errors that occur in your application, including
  | logging them or displaying custom views for specific errors. You may
  | even register several error handlers to handle different types of
  | exceptions. If nothing is returned, the default error view is
  | shown, which includes a detailed stack trace during debug.
  |
 */

App::error(function (Exception $exception, $code) {
    $pathInfo = Request::getPathInfo();
    $message = $exception->getMessage() ?: 'Exception';
    Log::error("$code - $message @ $pathInfo\r\n$exception");

    if (Config::get('app.debug')) {
        return null;
    }

    switch ($code) {
        case 403:
            return Response::view('error/403', array(), 403);

        case 500:
            return Response::view('error/500', array(), 500);

        default:
            return Response::view('error/404', array(), $code);
    }
});

/*
  |--------------------------------------------------------------------------
  | Maintenance Mode Handler
  |--------------------------------------------------------------------------
  |
  | The "down" Artisan command gives you the ability to put an application
  | into maintenance mode. Here, you will define what is displayed back
  | to the user if maintenace mode is in effect for this application.
  |
 */

App::down(function () {
    return Response::make("西贝貌似采取措施了，我找时间看看", 503);
});

/*
  |--------------------------------------------------------------------------
  | Require The Filters File
  |--------------------------------------------------------------------------
  |
  | Next we will load the filters file for the application. This gives us
  | a nice separate location to store our route and application filter
  | definitions instead of putting them all in the main routes file.
  |
 */

require __DIR__ . '/../filters.php';

# Util Methods
function d($var, $detail = null)
{
    echo '<pre>';
    ($detail) ? var_dump($var) : print_r($var);
    exit;
}

function mlog($msg)
{
    echo $msg . "\n";
    Log::info($msg);
}

function cbURL($articleId)
{
    return 'http://www.cnbeta.com/articles/' . $articleId . '.htm';
}

function postWeiboBySAE($content) {
    return file_get_contents('http://cnbeta1.sinaapp.com/post_weibo.php?cnbeta1=true&text=' . urlencode($content));
}

function replaceImgURL($content) {
    return str_replace('static.cnbetacdn.com', 'cnbeta1.sinaapp.com', $content);
}

# App shutdown
App::shutdown(function () {
    Cacher::close();
});

# Constants
const ARTICLE_CACHE_TIME = 1814400; // 3600 * 24 * 21, 21 days
const ARTICLE_REFRESH_TIME = 300; // 5min
const ARTICLE_RECENT_DAY = 2; // article in 1 day is 'recent'
# For cache keys
const ARTICLE_CACHE_KEY_PREFIX = 'A:';
const UPTODATE_KEY_PREFIX = 'U:';
const LATEST_ARTICLE_ID_KEY = 'LatestArticle';
const INDEX_CACHE_KEY = 'IndexData';
const FEED_CACHE_KEY = 'FeedData';
# Index Page
const INDEX_ARTICLE_NUM = 20;
const INDEX_EXPIRE_TIME = 180; // 3min

# Feed
const FEED_EXPIRE_TIME = 86400; // 1 day

# Init Cache Engine
Cacher::setCacher(new RedisCacher());
