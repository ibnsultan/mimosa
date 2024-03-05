<?php

chdir(dirname(__DIR__));

require 'vendor/autoload.php';
Dotenv\Dotenv::createImmutable(__DIR__, '../.env')->safeLoad();

require 'app/Routes/app.php';