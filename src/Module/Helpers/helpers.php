<?php

use \RefinedDigital\Team\Module\Http\Repositories\TeamRepository;

if (! function_exists('team')) {
    function team()
    {
        return app(TeamRepository::class);
    }
}
