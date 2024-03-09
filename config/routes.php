<?php
/*
 |----------------------------------------------------------------------------------
 | The URI Access file
 |----------------------------------------------------------------------------------
 | This handles file access rule for each route
 |
 | @expression {int}    - Integer values
 | @expression {slug}   - Alphanumerical values
 | @expression {any}    - Every character except slashes (/)
 | @expression {wild}   - Every character including slashes
 */
return [

    '' => [ 'session'=>false, 'access'=>'all' ],

    'auth/login' => 
        [ 'session' => false, 'access' => 'guest'],
    'auth/register' => 
        [ 'session' => false, 'access' => 'guest'],

    'app/settings' =>
        [ 'session' => true, 'access' => ['owner', 'admin'] ],

    'app/project/create' =>
        [ 'session' => true, 'access' => ['owner', 'admin'] ],

    'app/{wild}' =>
        [ 'session' => true, 'access' => ['user', 'owner', 'admin'] ],

    'admin/{any}' =>
        [ 'session' => true, 'access' => 'admin' ],   
        
    'api/auth/{wild}' =>
        [ 'session' => false, 'access' => 'guest' ],
    
    'api/{wild}' =>
        [ 'session' =>true, 'access' => ['subscriber', 'owner', 'admin'] ]


];