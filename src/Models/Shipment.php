<?php

namespace Anmartini\PosteTrack\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class Shipment implements Arrayable, Jsonable
{
    public Carbon $date;

    public string $status_label;

    public string $client_status_label;

    public string $status;

    public array $stickers;

    public function __construct(array $data)
    {
        $this->date = Carbon::createFromFormat('Y-m-d H:i:s', $data['data'], 'Europe/Rome');
        $this->status_label = $data['descrizioneStato'];
        $this->client_status_label = $data['descrizioneStatoCliente'];
        $this->status = $data['stato'];
        $this->stickers = $data['stickers'];
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'date' => $this->date->toIso8601String(),
            'status_label' => $this->status_label,
            'client_status_label' => $this->client_status_label,
            'status' => $this->status,
            'stickers' => $this->stickers,
        ];
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }
}
