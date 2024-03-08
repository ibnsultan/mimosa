<?php

namespace App\Controllers;

class PublicController extends \App\Controller
{
    public function home()
    {
        $data = [
            'title' => 'Mimosa',
            'description' => 'This is a framework designed to seamlessly integrate PHP and ReactJS without the need for complete separation between frontend and backend layers.'            
        ];

        render('Public', $data);

    }

}