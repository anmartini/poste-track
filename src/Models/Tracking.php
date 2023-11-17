<?php

namespace Anmartini\PosteTrack\Models;

use Exception;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;

class Tracking implements Arrayable, Jsonable
{
    const STATUS_PROCESSING = '2';

    const STATUS_DELIVERED = '5';

    const STATUSES = [
        self::STATUS_PROCESSING,
        self::STATUS_DELIVERED,
    ];

    public string $code;

    public string $type;

    public ?string $product;

    public string $result;

    public ?string $status;

    public ?bool $returned;

    public ?string $status_label;

    public string $actions;

    public Collection $updates;

    public ?bool $notified;

    public ?Shipment $shipment;

    protected ?array $raw_data;

    public function __construct(?array $data)
    {
        $this->code = $data['idTracciatura'] ?? '';
        $this->type = $data['tipoSpedizione'] ?? '';
        $this->product = $data['tipoProdotto'] ?? null;
        $this->result = $data['esitoRicerca'] ?? '';
        $this->status = $data['stato'] ?? null;
        $this->returned = $data['flagRitorno'] ?? null;
        $this->status_label = $data['sintesiStato'] ?? null;
        $this->actions = $data['azioni'] ?? '';
        $this->updates = Update::collect($data['listaMovimenti'] ?? null);
        $this->notified = $data['flagNotifica'] ?? null;

        try {
            $this->shipment = empty($data['spedizione']) ? null : new Shipment($data['spedizione']);
        } catch (Exception $e) {
            $this->shipment = null;
        }
        $this->raw_data = $data;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'code' => $this->code,
            'type' => $this->type,
            'product' => $this->product,
            'result' => $this->result,
            'status' => $this->status,
            'returned' => $this->returned,
            'status_label' => $this->status_label,
            'actions' => $this->actions,
            'updates' => $this->updates->map(fn (Update $update): array => $update->toArray())->all(),
            'notified' => $this->notified,
            'shipment' => optional($this->shipment)->toArray(),
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
     * Get the raw data from the request.
     */
    public function getRawData(): ?array
    {
        return $this->raw_data;
    }

    /**
     * Collect the trackings.
     */
    public static function collect(?array $data): Collection
    {
        if ($data === null) {
            return collect();
        }

        $trackings = collect();

        foreach ($data as $tracking) {
            try {
                $trackings->push(new self($tracking));
            } catch (Exception $e) {
            }
        }

        return $trackings;
    }
}
