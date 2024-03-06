<?php

namespace App\Controllers;

use App\Controller;

class HomeController extends Controller
{
    public function index()
    {
       
        $data = [
            'title' => 'Mimosa',
            'description' => 'This is a framework designed to seamlessly integrate PHP and ReactJS without the need for complete separation between frontend and backend layers.'            
        ];

        render('Home', $data);

    }

}