<?php

use App\Mvc;

$mvc = new Mvc();
$app = $mvc->getRouter();

$app->get('/', 'HomeController@index');
$app->get('/user/{name}', 'HomeController@user');

$app->run();