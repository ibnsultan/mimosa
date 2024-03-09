<?php

app->group('/api', function() {

    app->get('', function() {
        response()->json(['message' => 'Welcome to Mimosa API']);
    });

    app->post('/auth/login', fn()=>(new \App\Controllers\AuthController)->login(true));

});