<?php

Route::namespace('Team\Module\Http\Controllers')
    ->group(function() {
        Route::resource('team', 'TeamController');
    })
;
