<?php

namespace Anmartini\PosteTrack;

use Anmartini\PosteTrack\Models\DataMatrix;
use Anmartini\PosteTrack\Models\Tracking;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class PosteTrack
{
    /**
     * Track one or more shipment.
     *
     * @param  string|array  $codes
     * @return null|\Illuminate\Support\Collection|\Anmartini\PosteTrack\Models\Tracking
     */
    public static function track($codes)
    {
        $codes = Arr::wrap($codes);

        if (count($codes) === 0) {
            return null;
        } elseif (count($codes) === 1) {
            return self::trackSingle($codes[0]);
        } else {
            return self::trackMultiple($codes);
        }
    }

    /**
     * Track a single shipment.
     */
    public static function trackSingle(string $code): ?Tracking
    {
        $tries = 0;

        do {
            if ($tries > 0) {
                sleep(1);
            }

            $response = Http::withoutVerifying()
                ->timeout(config('poste-track.timeout', 30))
                ->post('https://www.poste.it/online/dovequando/DQ-REST/ricercasemplice', [
                    'tipoRichiedente' => 'WEB',
                    'codiceSpedizione' => $code,
                    'periodoRicerca' => 1,
                ]);

            $tries++;
        } while ($response->failed() && $tries <= config('poste-track.tries', 3));

        if ($response->failed()) {
            return null;
        }

        try {
            return new Tracking($response->json());
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Track multiple shipments.
     */
    public static function trackMultiple(array $codes): ?Collection
    {
        $tries = 0;

        do {
            if ($tries > 0) {
                sleep(1);
            }

            $response = Http::withoutVerifying()
                ->timeout(config('poste-track.timeout', 30))
                ->post('https://www.poste.it/online/dovequando/DQ-REST/ricercamultipla', [
                    'tipoRichiedente' => 'WEB',
                    'listaCodici' => $codes,
                ]);

            $tries++;
        } while ($response->failed() && $tries <= config('poste-track.tries', 3));

        if ($response->failed()) {
            return null;
        }

        try {
            return Tracking::collect($response->json());
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Track a shipment from DataMatrix
     */
    public static function trackFromDataMatrix(string $dataMatrix): ?Tracking
    {
        return (new DataMatrix($dataMatrix))->track();
    }
}
