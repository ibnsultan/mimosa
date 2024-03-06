<?php

namespace App\Controllers;

class HomeController extends \App\Controller
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