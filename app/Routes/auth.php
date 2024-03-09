<?php

app->group('auth', function(){

    app->get('login', function(){ render('Auth'); });
    app->get('register', function(){ render('Auth@register'); });
    
    app->get('reset', 'AuthController@reset');
    app->post('login', 'AuthController@login');
    app->post('register', 'AuthController@register');

});