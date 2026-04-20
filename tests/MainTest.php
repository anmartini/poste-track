<?php

use Anmartini\PosteTrack\Models\DataMatrix;
use Anmartini\PosteTrack\Models\Tracking;
use Anmartini\PosteTrack\PosteTrack;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

test('single request works', function () {
    Http::fake(Http::response('{"idTracciatura":"XA733804716IT","tipoSpedizione":"P","tipoProdotto":"POSTEDELIVERY EXPRESS","esitoRicerca":"3","stato":"5","flagRitorno":false,"sintesiStato":"La spedizione è stata consegnata in data 25-01-2021 11:42","azioni":"","listaMovimenti":[{"dataOra":1611313931000,"statoLavorazione":"Presa in carico da Ufficio Postale","luogo":"Ufficio Postale Bologna 14 di Piazza Dell Otto Agosto 24, 40126 Bologna (BO) ","flagRitorno":false,"idUfficio":"11163","denominazioneUfficio":"Bologna 14","indirizzoUfficio":"Piazza Dell Otto Agosto 24","capUfficio":"40126","comuneUfficio":"Bologna","provinciaUfficio":"BO","orarioUfficio":"LUN-VEN: 08:20-13:35 SAB: 08:20-12:35","orarioLunedi":"08:20-13:35","orarioMartedi":"08:20-13:35","orarioMercoledi":"08:20-13:35","orarioGiovedi":"08:20-13:35","orarioVenerdi":"08:20-13:35","orarioSabato":"08:20-12:35","orarioDomenica":"Chiuso"},{"dataOra":1611318780000,"statoLavorazione":"In transito","luogo":"Bologna (BO)","flagRitorno":false},{"dataOra":1611324420000,"statoLavorazione":"In lavorazione presso il Centro Operativo Postale","luogo":"Bologna (BO)","flagRitorno":false},{"dataOra":1611324420000,"statoLavorazione":"In transito presso il Centro Operativo Postale","luogo":"Bologna (BO)","flagRitorno":false},{"dataOra":1611362760000,"statoLavorazione":"In transito presso il Centro Operativo SDA","luogo":"Bologna Hub Espresso (BO)","flagRitorno":false},{"dataOra":1611362760000,"statoLavorazione":"In transito","luogo":"Bologna Hub Espresso (BO)","flagRitorno":false},{"dataOra":1611563040000,"statoLavorazione":"In consegna","luogo":"Centro Operativo SDA Modena (MO)","flagRitorno":false},{"dataOra":1611571320000,"statoLavorazione":"Consegnata","luogo":"Centro Operativo SDA Modena (MO)","flagRitorno":false}],"flagNotifica":false,"spedizione":{"data":"2021-01-25 11:42:00","descrizioneStato":"OK","descrizioneStatoCliente":"LA SPEDIZIONE E\' STATA CONSEGNATA","stato":"000","stickers":[]}}'));

    $tracking = PosteTrack::track('XA733804716IT');

    expect($tracking)->not->toBeNull()
        ->and($tracking)->toBeInstanceOf(Tracking::class)
        ->and($tracking->code)->toBe('XA733804716IT')
        ->and($tracking->status)->toBe(Tracking::STATUS_DELIVERED);
});

test('multiple request works', function () {
    Http::fake(Http::response('[{"idTracciatura":"2IUP0305509221","tipoSpedizione":"MT","tipoProdotto":"2IUP0305509221","esitoRicerca":"3","stato":"2","flagRitorno":false,"sintesiStato":"La spedizione e\' in stato di lavorazione","azioni":"","listaMovimenti":[{"dataOra":1605349090000,"statoLavorazione":"La spedizione e\' in stato di lavorazione","luogo":"BOLOGNA BO","flagRitorno":false}],"flagNotifica":false},{"idTracciatura":"XA733804716IT","tipoSpedizione":"P","tipoProdotto":"POSTEDELIVERY EXPRESS","esitoRicerca":"3","stato":"5","flagRitorno":false,"sintesiStato":"La spedizione è stata consegnata in data 25-01-2021 11:42","azioni":"","listaMovimenti":[{"dataOra":1611313931000,"statoLavorazione":"Presa in carico da Ufficio Postale","luogo":"Ufficio Postale Bologna 14 di Piazza Dell Otto Agosto 24, 40126 Bologna (BO) ","flagRitorno":false,"idUfficio":"11163","denominazioneUfficio":"Bologna 14","indirizzoUfficio":"Piazza Dell Otto Agosto 24","capUfficio":"40126","comuneUfficio":"Bologna","provinciaUfficio":"BO","orarioUfficio":"LUN-VEN: 08:20-13:35 SAB: 08:20-12:35","orarioLunedi":"08:20-13:35","orarioMartedi":"08:20-13:35","orarioMercoledi":"08:20-13:35","orarioGiovedi":"08:20-13:35","orarioVenerdi":"08:20-13:35","orarioSabato":"08:20-12:35","orarioDomenica":"Chiuso"},{"dataOra":1611318780000,"statoLavorazione":"In transito","luogo":"Bologna (BO)","flagRitorno":false},{"dataOra":1611324420000,"statoLavorazione":"In lavorazione presso il Centro Operativo Postale","luogo":"Bologna (BO)","flagRitorno":false},{"dataOra":1611324420000,"statoLavorazione":"In transito presso il Centro Operativo Postale","luogo":"Bologna (BO)","flagRitorno":false},{"dataOra":1611362760000,"statoLavorazione":"In transito presso il Centro Operativo SDA","luogo":"Bologna Hub Espresso (BO)","flagRitorno":false},{"dataOra":1611362760000,"statoLavorazione":"In transito","luogo":"Bologna Hub Espresso (BO)","flagRitorno":false},{"dataOra":1611563040000,"statoLavorazione":"In consegna","luogo":"Centro Operativo SDA Modena (MO)","flagRitorno":false},{"dataOra":1611571320000,"statoLavorazione":"Consegnata","luogo":"Centro Operativo SDA Modena (MO)","flagRitorno":false}],"flagNotifica":false,"spedizione":{"data":"2021-01-25 11:42:00","descrizioneStato":"OK","descrizioneStatoCliente":"LA SPEDIZIONE E\' STATA CONSEGNATA","stato":"000","stickers":[]}}]'));

    $trackings = PosteTrack::track(['2IUP0305509221', 'XA733804716IT']);

    expect($trackings)->not->toBeNull()
        ->and($trackings)->toBeInstanceOf(Collection::class)
        ->and($trackings)->toHaveCount(2)
        ->and($trackings->get(0)->code)->toBe('2IUP0305509221')
        ->and($trackings->get(1)->code)->toBe('XA733804716IT')
        ->and($trackings->get(0)->status)->toBe(Tracking::STATUS_PROCESSING)
        ->and($trackings->get(1)->status)->toBe(Tracking::STATUS_DELIVERED);
});

test('data matrix is correctly parsed', function () {
    $data = '1 10000105   2199999    99999    IUP0305509189   YY9999             ZZZZ';

    $dataMatrix = new DataMatrix($data);

    expect($dataMatrix->identificativo)->toBe('1')
        ->and($dataMatrix->descrittivo_gamma)->toBe(' ')
        ->and($dataMatrix->id_cliente_sap)->toBe('10000105')
        ->and($dataMatrix->identificativo_cliente_mittente)->toBe('   ')
        ->and($dataMatrix->classe)->toBe('2')
        ->and($dataMatrix->tipologia_prodotto)->toBe('1')
        ->and($dataMatrix->cap_destinatario)->toBe('99999')
        ->and($dataMatrix->codice_tecnico_destinatario)->toBe('    ')
        ->and($dataMatrix->cap_mittente)->toBe('99999')
        ->and($dataMatrix->codice_tecnico_mittente)->toBe('    ')
        ->and($dataMatrix->codice_id_prenotazione)->toBe('IUP03')
        ->and($dataMatrix->identificativo_stampatore)->toBe('05')
        ->and($dataMatrix->identificativo_oggetto)->toBe('509189')
        ->and($dataMatrix->causale)->toBe('   ')
        ->and($dataMatrix->codice_omologazione)->toBe('YY9999')
        ->and($dataMatrix->disponibile_per_il_cliente)->toBe('         ')
        ->and($dataMatrix->servizi_accessori)->toBe('    ZZZZ');
});

test('data matrix tracking code is correct', function () {
    $data = '1 10000105   2199999    99999    IUP0305509189   YY9999             ZZZZ';

    $dataMatrix = new DataMatrix($data);

    expect($dataMatrix->getTrackingCode())->toBe('2IUP0305509189');
});

test('data matrix prioritario is correct', function () {
    $data = '1 10000105   2199999    99999    IUP0305509189   YY9999             ZZZZ';

    $dataMatrix = new DataMatrix($data);

    expect($dataMatrix->isPrioritario())->toBeTrue();
});

test('data matrix classe is correct', function () {
    $data = '1 10000105   2199999    99999    IUP0305509189   YY9999             ZZZZ';

    $dataMatrix = new DataMatrix($data);

    expect($dataMatrix->getClasse())->toBe(DataMatrix::CLASSE[DataMatrix::CLASSE_PRIORITARIA]);
});

test('data matrix gamma is correct', function () {
    $data = '1B10000105   2199999    99999    IUP0305509189   YY9999             ZZZZ';

    $dataMatrix = new DataMatrix($data);

    expect($dataMatrix->getDescrittivoGamma())->toBe(DataMatrix::GAMMA[DataMatrix::GAMMA_BULK_MAIL]);
});

test('data matrix is tracked', function () {
    $data = '1 10000105   2199999    99999    IUP0305509189   YY9999             ZZZZ';

    $dataMatrix = new DataMatrix($data);

    Http::fake(Http::response('{"idTracciatura":"2IUP0305509189","tipoSpedizione":"MT","esitoRicerca":"2","azioni":""}'));

    $tracking = $dataMatrix->track();

    expect($tracking)->not->toBeNull()
        ->and($tracking)->toBeInstanceOf(Tracking::class)
        ->and($tracking->code)->toBe($dataMatrix->getTrackingCode());
});
