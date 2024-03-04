<?php

namespace App\Controllers;

use App\Mvc;
use stdClass;

class HomeController extends Mvc
{
    public function index()
    {
        $description = new stdClass;

        $description->firstPoint = 'Mimosa is a php framework designed to directly work with react without completely separating the layers of the application';
        $description->secondPoint = 'It is built on top of Framework-X, therefore speed is guaranteed';

        $data = [
            'title' => 'Welcome to Mimosa!',
            'descriptions' => $description                
        ];

        return $this->render('Home', $data);

    }

}