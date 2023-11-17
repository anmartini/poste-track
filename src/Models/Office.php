<?php

namespace Anmartini\PosteTrack\Models;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class Office implements Arrayable, Jsonable
{
    public string $id;

    public string $name;

    public string $street_address;

    public string $zip;

    public string $city;

    public string $country;

    public array $opening_times;

    public string $opening_times_label;

    public function __construct(array $data)
    {
        $this->id = $data['idUfficio'];
        $this->name = $data['denominazioneUfficio'];
        $this->street_address = $data['indirizzoUfficio'];
        $this->zip = $data['capUfficio'];
        $this->city = $data['comuneUfficio'];
        $this->country = $data['provinciaUfficio'];
        $this->opening_times = [
            1 => $data['orarioLunedi'],
            2 => $data['orarioMartedi'],
            3 => $data['orarioMercoledi'],
            4 => $data['orarioGiovedi'],
            5 => $data['orarioVenerdi'],
            6 => $data['orarioSabato'],
            7 => $data['orarioDomenica'],
        ];
        $this->opening_times_label = $data['orarioUfficio'];
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'street_address' => $this->street_address,
            'zip' => $this->zip,
            'city' => $this->city,
            'country' => $this->country,
            'opening_times' => $this->opening_times,
            'opening_times_label' => $this->opening_times_label,
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
