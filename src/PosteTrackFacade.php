<?php

namespace Anmartini\PosteTrack;

use Illuminate\Support\Facades\Facade;

/**
 * @see PosteTrack
 */
class PosteTrackFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'poste-track';
    }
}
