<?php

namespace Anmartini\PosteTrack\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;

class Update implements Arrayable, Jsonable
{
    public Carbon $date;
    public string $status;
    public string $place;
    public bool $returned;
    public ?Office $office;

    public function __construct(array $data)
    {
        $this->date = Carbon::createFromTimestampMs($data['dataOra'])->setTimezone('Europe/Rome');
        $this->status = $data['statoLavorazione'];
        $this->place = $data['luogo'];
        $this->returned = $data['flagRitorno'];

        try {
            $this->office = empty($data['idUfficio']) ? null : new Office($data);
        } catch (Exception $e) {
            $this->office = null;
        }
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
            'status' => $this->status,
            'place' => $this->place,
            'returned' => $this->returned,
            'office' => optional($this->office)->toArray(),
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

    /**
     * Collect the updates.
     *
     * @param array|null $data
     * @return \Illuminate\Support\Collection
     */
    public static function collect(?array $data) : Collection
    {
        if ($data === null) {
            return collect();
        }

        $updates = collect();

        foreach ($data as $update) {
            try {
                $updates->push(new self($update));
            } catch (Exception $e) {
            }
        }

        return $updates;
    }
}
