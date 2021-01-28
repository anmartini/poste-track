<?php

namespace Anmartini\PosteTrack\Commands;

use Anmartini\PosteTrack\PosteTrack;
use Illuminate\Console\Command;

class PosteTrackCommand extends Command
{
    public $signature = 'poste-track {--D|data-matrix : Use a DataMatrix} {code : The code of the shipment to track}';

    public $description = 'Track a shipment';

    public function handle()
    {
        if ($this->option('data-matrix')) {
            return PosteTrack::trackFromDataMatrix($this->argument('code'));
        }

        return PosteTrack::track($this->argument('code'));
    }
}
