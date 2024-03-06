<?php

app->group('/api', function() {
    
    app->get('', function() {
        response()->json(['message' => 'Welcome to Mimosa API']);
    });

});