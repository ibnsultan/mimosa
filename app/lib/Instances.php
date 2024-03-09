<?php

/**
 *------------------------------------------------------------------------------
 * Instances
 *------------------------------------------------------------------------------
 *
 * Path: app/lib/Instances.php
 * Author: Abdulbasit Rubeiyya
 * Last Updated: 8 March 2024
 *
 * This file is used to define global instances that can be used throughout the
 * application. This file is loaded in the app/lib/Functions.php file.
 *
*/

/*
|--------------------------------------------------------------------------
| Initialize the Faker Factory
|--------------------------------------------------------------------------
|
| This is used to generate fake data for the application.
|
*/
define('faker', (Faker\Factory::create()) ?? null);

/*
|--------------------------------------------------------------------------
| Get the Configurations
|--------------------------------------------------------------------------
|
| This is used to get the configurations for the application.
|
*/
define('config', require_once getcwd() . '/config/app.php');
