<?php

namespace Anmartini\PosteTrack\Models;

use Anmartini\PosteTrack\PosteTrack;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Str;
use InvalidArgumentException;

class DataMatrix implements Arrayable, Jsonable
{
    const GAMMA_BULK_MAIL = 'B';

    const GAMMA_EDITORIA = 'E';

    const GAMMA_POSTA_TARGET = 'T';

    const GAMMA_POSTA_TIME = 'V';

    const GAMMA = [
        self::GAMMA_BULK_MAIL => 'Bulk Mail',
        self::GAMMA_EDITORIA => 'Editoria',
        self::GAMMA_POSTA_TARGET => 'Posta Target',
        self::GAMMA_POSTA_TIME => 'Posta Time',
    ];

    const CLASSE_PRIORITARIA = '2';

    const CLASSE_ORDINARIA = '1';

    const CLASSE = [
        self::CLASSE_PRIORITARIA => 'Prioritaria',
        self::CLASSE_ORDINARIA => 'Ordinaria',
    ];

    const TIPOLOGIA_PRODOTTO_PERIODICO = 'Y';

    const TIPOLOGIA_PRODOTTO_PIEGHI_DI_LIBRI = 'X';

    const TIPOLOGIA_PRODOTTO_PROMOZIONE_ABBONAMENTO = 'S';

    const TIPOLOGIA_PRODOTTO_BILLING_MAIL = 'Y';

    const TIPOLOGIA_PRODOTTO_POSTA1_PRO = 'X';

    const TIPOLOGIA_PRODOTTO_POSTA_MASSIVA = 'W';

    const TIPOLOGIA_PRODOTTO_GOLD = 'Q';

    const TIPOLOGIA_PRODOTTO_BASIC = 'S';

    const TIPOLOGIA_PRODOTTO_CARD = 'U';

    const TIPOLOGIA_PRODOTTO_CREATIVE = 'W';

    const TIPOLOGIA_PRODOTTO_CATALOG = 'V';

    const TIPOLOGIA_PRODOTTO_MAGAZINE = 'Z';

    const TIPOLOGIA_PRODOTTO_POSTA_TIME_BASE = 'Q';

    const TIPOLOGIA_PRODOTTO_POSTA_TIME_ORA = 'S';

    const TIPOLOGIA_PRODOTTO_STAMPE_PERIODICHE_IN_REGIME_LIBERO = 'U';

    const TIPOLOGIA_PRODOTTO_PROMOZIONI_NO_PROFIT = 'Q';

    const TIPOLOGIA_PRODOTTO_PUBBLICAZIONI_INFORMATIVE_NO_PROFIT = 'W';

    const TIPOLOGIA_PRODOTTO_PREMIUM_PRESS = 'V';

    const TIPOLOGIA_PRODOTTO_CONSEGNA_MULTICOPIE = 'Z';

    const TIPOLOGIA_PRODOTTO_SVILUPPO_CUSTOMER_BASE = 'X';

    const TIPOLOGIA_PRODOTTO_INVITO_ALLA_PROVA = 'Y';

    const TIPOLOGIA_PRODOTTO_POSTA_CONTEST1 = 'Q';

    const TIPOLOGIA_PRODOTTO_POSTA_CONTEST4 = 'S';

    const TIPOLOGIA_PRODOTTO_POSTA_TIME_OPERATORI = 'T';

    const TIPOLOGIA_PRODOTTO = [
        self::GAMMA_BULK_MAIL => [
            self::TIPOLOGIA_PRODOTTO_BILLING_MAIL => 'Billing Mail',
            self::TIPOLOGIA_PRODOTTO_POSTA1_PRO => 'Posta 1 Pro',
            self::TIPOLOGIA_PRODOTTO_POSTA_MASSIVA => 'Posta Massiva',
            self::TIPOLOGIA_PRODOTTO_POSTA_CONTEST1 => 'Posta contest 1',
            self::TIPOLOGIA_PRODOTTO_POSTA_CONTEST4 => 'Posta contest 4',
        ],
        self::GAMMA_EDITORIA => [
            self::TIPOLOGIA_PRODOTTO_PERIODICO => 'Periodico',
            self::TIPOLOGIA_PRODOTTO_PIEGHI_DI_LIBRI => 'Pieghi di libri',
            self::TIPOLOGIA_PRODOTTO_PROMOZIONE_ABBONAMENTO => 'Promozione abbonamento',
            self::TIPOLOGIA_PRODOTTO_STAMPE_PERIODICHE_IN_REGIME_LIBERO => 'Stampe periodiche in regime libero',
            self::TIPOLOGIA_PRODOTTO_PROMOZIONI_NO_PROFIT => 'Promozioni no profit',
            self::TIPOLOGIA_PRODOTTO_PUBBLICAZIONI_INFORMATIVE_NO_PROFIT => 'Pubblicazioni informative no profit',
            self::TIPOLOGIA_PRODOTTO_PREMIUM_PRESS => 'Premium Press',
            self::TIPOLOGIA_PRODOTTO_CONSEGNA_MULTICOPIE => 'Consegna multicopie',
        ],
        self::GAMMA_POSTA_TARGET => [
            self::TIPOLOGIA_PRODOTTO_GOLD => 'Gold',
            self::TIPOLOGIA_PRODOTTO_BASIC => 'Basic',
            self::TIPOLOGIA_PRODOTTO_CARD => 'Card',
            self::TIPOLOGIA_PRODOTTO_CREATIVE => 'Creative',
            self::TIPOLOGIA_PRODOTTO_CATALOG => 'Catalog',
            self::TIPOLOGIA_PRODOTTO_MAGAZINE => 'Magazine',
            self::TIPOLOGIA_PRODOTTO_SVILUPPO_CUSTOMER_BASE => 'Sviluppo customer base',
            self::TIPOLOGIA_PRODOTTO_INVITO_ALLA_PROVA => 'Invito alla prova',
        ],
        self::GAMMA_POSTA_TIME => [
            self::TIPOLOGIA_PRODOTTO_POSTA_TIME_BASE => 'Base',
            self::TIPOLOGIA_PRODOTTO_POSTA_TIME_ORA => 'Ora',
            self::TIPOLOGIA_PRODOTTO_POSTA_TIME_OPERATORI => 'Operatori',
        ],
    ];

    const CLASSE_TIPOLOGIA_PRODOTTO = [
        self::GAMMA_BULK_MAIL => [
            self::TIPOLOGIA_PRODOTTO_BILLING_MAIL => self::CLASSE_ORDINARIA,
            self::TIPOLOGIA_PRODOTTO_POSTA1_PRO => self::CLASSE_PRIORITARIA,
            self::TIPOLOGIA_PRODOTTO_POSTA_MASSIVA => self::CLASSE_ORDINARIA,
            self::TIPOLOGIA_PRODOTTO_POSTA_CONTEST1 => self::CLASSE_PRIORITARIA,
            self::TIPOLOGIA_PRODOTTO_POSTA_CONTEST4 => self::CLASSE_ORDINARIA,
        ],
        self::GAMMA_EDITORIA => [
            self::TIPOLOGIA_PRODOTTO_PERIODICO => self::CLASSE_ORDINARIA,
            self::TIPOLOGIA_PRODOTTO_PIEGHI_DI_LIBRI => self::CLASSE_ORDINARIA,
            self::TIPOLOGIA_PRODOTTO_PROMOZIONE_ABBONAMENTO => self::CLASSE_ORDINARIA,
            self::TIPOLOGIA_PRODOTTO_STAMPE_PERIODICHE_IN_REGIME_LIBERO => self::CLASSE_ORDINARIA,
            self::TIPOLOGIA_PRODOTTO_PROMOZIONI_NO_PROFIT => self::CLASSE_ORDINARIA,
            self::TIPOLOGIA_PRODOTTO_PUBBLICAZIONI_INFORMATIVE_NO_PROFIT => self::CLASSE_ORDINARIA,
            self::TIPOLOGIA_PRODOTTO_PREMIUM_PRESS => self::CLASSE_ORDINARIA,
            self::TIPOLOGIA_PRODOTTO_CONSEGNA_MULTICOPIE => self::CLASSE_ORDINARIA,
        ],
        self::GAMMA_POSTA_TARGET => [
            self::TIPOLOGIA_PRODOTTO_GOLD => self::CLASSE_ORDINARIA,
            self::TIPOLOGIA_PRODOTTO_BASIC => self::CLASSE_ORDINARIA,
            self::TIPOLOGIA_PRODOTTO_CARD => self::CLASSE_ORDINARIA,
            self::TIPOLOGIA_PRODOTTO_CREATIVE => self::CLASSE_ORDINARIA,
            self::TIPOLOGIA_PRODOTTO_CATALOG => self::CLASSE_ORDINARIA,
            self::TIPOLOGIA_PRODOTTO_MAGAZINE => self::CLASSE_ORDINARIA,
            self::TIPOLOGIA_PRODOTTO_SVILUPPO_CUSTOMER_BASE => self::CLASSE_ORDINARIA,
            self::TIPOLOGIA_PRODOTTO_INVITO_ALLA_PROVA => self::CLASSE_ORDINARIA,
        ],
        self::GAMMA_POSTA_TIME => [
            self::TIPOLOGIA_PRODOTTO_POSTA_TIME_BASE => self::CLASSE_ORDINARIA,
            self::TIPOLOGIA_PRODOTTO_POSTA_TIME_ORA => self::CLASSE_ORDINARIA,
            self::TIPOLOGIA_PRODOTTO_POSTA_TIME_OPERATORI => self::CLASSE_ORDINARIA,
        ],
    ];

    public string $identificativo;

    public string $descrittivo_gamma;

    public string $id_cliente_sap;

    public string $identificativo_cliente_mittente;

    public string $classe;

    public string $tipologia_prodotto;

    public string $cap_destinatario;

    public string $codice_tecnico_destinatario;

    public string $cap_mittente;

    public string $codice_tecnico_mittente;

    public string $codice_id_prenotazione;

    public string $identificativo_stampatore;

    public string $identificativo_oggetto;

    public string $causale;

    public string $codice_omologazione;

    public string $disponibile_per_il_cliente;

    public string $servizi_accessori;

    public function __construct(string $data)
    {
        if (Str::length($data) !== 72) {
            throw new InvalidArgumentException('Data string must have 72 characters.');
        }

        $this->identificativo = Str::substr($data, 0, 1);
        $this->descrittivo_gamma = Str::substr($data, 1, 1);
        $this->id_cliente_sap = Str::substr($data, 2, 8);
        $this->identificativo_cliente_mittente = Str::substr($data, 10, 3);
        $this->classe = Str::substr($data, 13, 1);
        $this->tipologia_prodotto = Str::substr($data, 14, 1);
        $this->cap_destinatario = Str::substr($data, 15, 5);
        $this->codice_tecnico_destinatario = Str::substr($data, 20, 4);
        $this->cap_mittente = Str::substr($data, 24, 5);
        $this->codice_tecnico_mittente = Str::substr($data, 29, 4);
        $this->codice_id_prenotazione = Str::substr($data, 33, 5);
        $this->identificativo_stampatore = Str::substr($data, 38, 2);
        $this->identificativo_oggetto = Str::substr($data, 40, 6);
        $this->causale = Str::substr($data, 46, 3);
        $this->codice_omologazione = Str::substr($data, 49, 6);
        $this->disponibile_per_il_cliente = Str::substr($data, 55, 9);
        $this->servizi_accessori = Str::substr($data, 64, 8);
    }

    /**
     * Get the printed tracking code
     */
    public function getTrackingCode(): string
    {
        return "{$this->classe}{$this->codice_id_prenotazione}{$this->identificativo_stampatore}{$this->identificativo_oggetto}";
    }

    /**
     * Get the gamma label.
     */
    public function getDescrittivoGamma(): ?string
    {
        return self::GAMMA[$this->descrittivo_gamma] ?? null;
    }

    /**
     * Get the classe label.
     */
    public function getClasse(): ?string
    {
        return self::CLASSE[intval($this->classe)] ?? null;
    }

    /**
     * Get the tipologia prodotto label.
     */
    public function getTipologiaProdotto(): ?string
    {
        return self::TIPOLOGIA_PRODOTTO[$this->descrittivo_gamma][$this->tipologia_prodotto] ?? null;
    }

    /**
     * Check if the shipment is prioritary.
     */
    public function isPrioritario(): bool
    {
        return $this->classe === self::CLASSE_PRIORITARIA;
    }

    /**
     * Track the shipment.
     */
    public function track(): ?Tracking
    {
        return PosteTrack::trackSingle($this->getTrackingCode());
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'identificativo' => $this->identificativo,
            'descrittivo_gamma' => $this->descrittivo_gamma,
            'id_cliente_sap' => $this->id_cliente_sap,
            'identificativo_cliente_mittente' => $this->identificativo_cliente_mittente,
            'classe' => $this->classe,
            'tipologia_prodotto' => $this->tipologia_prodotto,
            'cap_destinatario' => $this->cap_destinatario,
            'codice_tecnico_destinatario' => $this->codice_tecnico_destinatario,
            'cap_mittente' => $this->cap_mittente,
            'codice_tecnico_mittente' => $this->codice_tecnico_mittente,
            'codice_id_prenotazione' => $this->codice_id_prenotazione,
            'identificativo_stampatore' => $this->identificativo_stampatore,
            'identificativo_oggetto' => $this->identificativo_oggetto,
            'causale' => $this->causale,
            'codice_omologazione' => $this->codice_omologazione,
            'disponibile_per_il_cliente' => $this->disponibile_per_il_cliente,
            'servizi_accessori' => $this->servizi_accessori,
            'descrittivo_gamma_label' => $this->getDescrittivoGamma(),
            'classe_label' => $this->getClasse(),
            'tipologia_prodotto_label' => $this->getTipologiaProdotto(),
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
