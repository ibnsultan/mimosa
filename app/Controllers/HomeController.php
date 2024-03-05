<?php

namespace App\Controllers;

use App\Mvc;

class HomeController extends Mvc
{
    public function index()
    {
       
        $data = [
            'title' => 'Mimosa',
            'description' => 'This is a framework designed to seamlessly integrate PHP and ReactJS without the need for complete separation between frontend and backend layers.'            
        ];

        return $this->render('Home', $data);

    }

}