<?php
$HomeController = new \App\Controllers\HomeController;
$PostController = new \App\Controllers\PostController;
$ShortenerController = new \App\Controllers\ShortenerController;


$app->route('GET /', array($HomeController, 'index'));
$app->route('GET /convert', array($PostController, 'convert'));
$app->route('POST /convert', array($PostController, 'convert_ajax'));
$app->route('POST /shorten', array($ShortenerController, 'create'));
$app->route('GET /s/@code', array($ShortenerController, 'redirect'));
$app->route('GET /script', array($HomeController, 'fullpage'));
$app->route('GET /page/fullpage', function() use ($app) {
    $app->redirect(base_url('script'));
});
$app->route('GET /@slug', array($PostController, 'index'));
