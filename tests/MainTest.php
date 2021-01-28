<?php

namespace Anmartini\PosteTrack\Tests;

use Anmartini\PosteTrack\Models\DataMatrix;
use Anmartini\PosteTrack\Models\Tracking;
use Anmartini\PosteTrack\PosteTrack;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class MainTest extends TestCase
{
    /** @test */
    public function single_request_works()
    {
        Http::fake(Http::response('{"idTracciatura":"XA733804716IT","tipoSpedizione":"P","tipoProdotto":"POSTEDELIVERY EXPRESS","esitoRicerca":"3","stato":"5","flagRitorno":false,"sintesiStato":"La spedizione è stata consegnata in data 25-01-2021 11:42","azioni":"","listaMovimenti":[{"dataOra":1611313931000,"statoLavorazione":"Presa in carico da Ufficio Postale","luogo":"Ufficio Postale Bologna 14 di Piazza Dell Otto Agosto 24, 40126 Bologna (BO) ","flagRitorno":false,"idUfficio":"11163","denominazioneUfficio":"Bologna 14","indirizzoUfficio":"Piazza Dell Otto Agosto 24","capUfficio":"40126","comuneUfficio":"Bologna","provinciaUfficio":"BO","orarioUfficio":"LUN-VEN: 08:20-13:35 SAB: 08:20-12:35","orarioLunedi":"08:20-13:35","orarioMartedi":"08:20-13:35","orarioMercoledi":"08:20-13:35","orarioGiovedi":"08:20-13:35","orarioVenerdi":"08:20-13:35","orarioSabato":"08:20-12:35","orarioDomenica":"Chiuso"},{"dataOra":1611318780000,"statoLavorazione":"In transito","luogo":"Bologna (BO)","flagRitorno":false},{"dataOra":1611324420000,"statoLavorazione":"In lavorazione presso il Centro Operativo Postale","luogo":"Bologna (BO)","flagRitorno":false},{"dataOra":1611324420000,"statoLavorazione":"In transito presso il Centro Operativo Postale","luogo":"Bologna (BO)","flagRitorno":false},{"dataOra":1611362760000,"statoLavorazione":"In transito presso il Centro Operativo SDA","luogo":"Bologna Hub Espresso (BO)","flagRitorno":false},{"dataOra":1611362760000,"statoLavorazione":"In transito","luogo":"Bologna Hub Espresso (BO)","flagRitorno":false},{"dataOra":1611563040000,"statoLavorazione":"In consegna","luogo":"Centro Operativo SDA Modena (MO)","flagRitorno":false},{"dataOra":1611571320000,"statoLavorazione":"Consegnata","luogo":"Centro Operativo SDA Modena (MO)","flagRitorno":false}],"flagNotifica":false,"spedizione":{"data":"2021-01-25 11:42:00","descrizioneStato":"OK","descrizioneStatoCliente":"LA SPEDIZIONE E\' STATA CONSEGNATA","stato":"000","stickers":[]}}'));

        $tracking = PosteTrack::track('XA733804716IT');

        $this->assertNotNull($tracking);
        $this->assertInstanceOf(Tracking::class, $tracking);
        $this->assertEquals('XA733804716IT', $tracking->code);
        $this->assertEquals(Tracking::STATUS_DELIVERED, $tracking->status);
    }

    /** @test */
    public function multiple_request_works()
    {
        Http::fake(Http::response('[{"idTracciatura":"2IUP0305509221","tipoSpedizione":"MT","tipoProdotto":"2IUP0305509221","esitoRicerca":"3","stato":"2","flagRitorno":false,"sintesiStato":"La spedizione e\' in stato di lavorazione","azioni":"","listaMovimenti":[{"dataOra":1605349090000,"statoLavorazione":"La spedizione e\' in stato di lavorazione","luogo":"BOLOGNA BO","flagRitorno":false}],"flagNotifica":false},{"idTracciatura":"XA733804716IT","tipoSpedizione":"P","tipoProdotto":"POSTEDELIVERY EXPRESS","esitoRicerca":"3","stato":"5","flagRitorno":false,"sintesiStato":"La spedizione è stata consegnata in data 25-01-2021 11:42","azioni":"","listaMovimenti":[{"dataOra":1611313931000,"statoLavorazione":"Presa in carico da Ufficio Postale","luogo":"Ufficio Postale Bologna 14 di Piazza Dell Otto Agosto 24, 40126 Bologna (BO) ","flagRitorno":false,"idUfficio":"11163","denominazioneUfficio":"Bologna 14","indirizzoUfficio":"Piazza Dell Otto Agosto 24","capUfficio":"40126","comuneUfficio":"Bologna","provinciaUfficio":"BO","orarioUfficio":"LUN-VEN: 08:20-13:35 SAB: 08:20-12:35","orarioLunedi":"08:20-13:35","orarioMartedi":"08:20-13:35","orarioMercoledi":"08:20-13:35","orarioGiovedi":"08:20-13:35","orarioVenerdi":"08:20-13:35","orarioSabato":"08:20-12:35","orarioDomenica":"Chiuso"},{"dataOra":1611318780000,"statoLavorazione":"In transito","luogo":"Bologna (BO)","flagRitorno":false},{"dataOra":1611324420000,"statoLavorazione":"In lavorazione presso il Centro Operativo Postale","luogo":"Bologna (BO)","flagRitorno":false},{"dataOra":1611324420000,"statoLavorazione":"In transito presso il Centro Operativo Postale","luogo":"Bologna (BO)","flagRitorno":false},{"dataOra":1611362760000,"statoLavorazione":"In transito presso il Centro Operativo SDA","luogo":"Bologna Hub Espresso (BO)","flagRitorno":false},{"dataOra":1611362760000,"statoLavorazione":"In transito","luogo":"Bologna Hub Espresso (BO)","flagRitorno":false},{"dataOra":1611563040000,"statoLavorazione":"In consegna","luogo":"Centro Operativo SDA Modena (MO)","flagRitorno":false},{"dataOra":1611571320000,"statoLavorazione":"Consegnata","luogo":"Centro Operativo SDA Modena (MO)","flagRitorno":false}],"flagNotifica":false,"spedizione":{"data":"2021-01-25 11:42:00","descrizioneStato":"OK","descrizioneStatoCliente":"LA SPEDIZIONE E\' STATA CONSEGNATA","stato":"000","stickers":[]}}]'));

        $trackings = PosteTrack::track(['2IUP0305509221', 'XA733804716IT']);

        $this->assertNotNull($trackings);
        $this->assertInstanceOf(Collection::class, $trackings);
        $this->assertCount(2, $trackings);
        $this->assertEquals('2IUP0305509221', $trackings->get(0)->code);
        $this->assertEquals('XA733804716IT', $trackings->get(1)->code);
        $this->assertEquals(Tracking::STATUS_PROCESSING, $trackings->get(0)->status);
        $this->assertEquals(Tracking::STATUS_DELIVERED, $trackings->get(1)->status);
    }

    /** @test */
    public function data_matrix_is_correctly_parsed()
    {
        $data = '1 10000105   2199999    99999    IUP0305509189   YY9999             ZZZZ';

        $dataMatrix = new DataMatrix($data);

        $this->assertEquals('1', $dataMatrix->identificativo);
        $this->assertEquals(' ', $dataMatrix->descrittivo_gamma);
        $this->assertEquals('10000105', $dataMatrix->id_cliente_sap);
        $this->assertEquals('   ', $dataMatrix->identificativo_cliente_mittente);
        $this->assertEquals('2', $dataMatrix->classe);
        $this->assertEquals('1', $dataMatrix->tipologia_prodotto);
        $this->assertEquals('99999', $dataMatrix->cap_destinatario);
        $this->assertEquals('    ', $dataMatrix->codice_tecnico_destinatario);
        $this->assertEquals('99999', $dataMatrix->cap_mittente);
        $this->assertEquals('    ', $dataMatrix->codice_tecnico_mittente);
        $this->assertEquals('IUP03', $dataMatrix->codice_id_prenotazione);
        $this->assertEquals('05', $dataMatrix->identificativo_stampatore);
        $this->assertEquals('509189', $dataMatrix->identificativo_oggetto);
        $this->assertEquals('   ', $dataMatrix->causale);
        $this->assertEquals('YY9999', $dataMatrix->codice_omologazione);
        $this->assertEquals('         ', $dataMatrix->disponibile_per_il_cliente);
        $this->assertEquals('    ZZZZ', $dataMatrix->servizi_accessori);
    }

    /** @test */
    public function data_matrix_tracking_code_is_correct()
    {
        $data = '1 10000105   2199999    99999    IUP0305509189   YY9999             ZZZZ';

        $dataMatrix = new DataMatrix($data);

        $this->assertEquals('2IUP0305509189', $dataMatrix->getTrackingCode());
    }

    /** @test */
    public function data_matrix_prioritario_is_correct()
    {
        $data = '1 10000105   2199999    99999    IUP0305509189   YY9999             ZZZZ';

        $dataMatrix = new DataMatrix($data);

        $this->assertTrue($dataMatrix->isPrioritario());
    }

    /** @test */
    public function data_matrix_classe_is_correct()
    {
        $data = '1 10000105   2199999    99999    IUP0305509189   YY9999             ZZZZ';

        $dataMatrix = new DataMatrix($data);

        $this->assertEquals(DataMatrix::CLASSE[DataMatrix::CLASSE_PRIORITARIA], $dataMatrix->getClasse());
    }

    /** @test */
    public function data_matrix_gamma_is_correct()
    {
        $data = '1B10000105   2199999    99999    IUP0305509189   YY9999             ZZZZ';

        $dataMatrix = new DataMatrix($data);

        $this->assertEquals(DataMatrix::GAMMA[DataMatrix::GAMMA_BULK_MAIL], $dataMatrix->getDescrittivoGamma());
    }

    /** @test */
    public function data_matrix_is_tracked()
    {
        $data = '1 10000105   2199999    99999    IUP0305509189   YY9999             ZZZZ';

        $dataMatrix = new DataMatrix($data);

        Http::fake(Http::response('{"idTracciatura":"2IUP0305509189","tipoSpedizione":"MT","esitoRicerca":"2","azioni":""}'));

        $tracking = $dataMatrix->track();

        $this->assertNotNull($tracking);
        $this->assertInstanceOf(Tracking::class, $tracking);
        $this->assertEquals($dataMatrix->getTrackingCode(), $tracking->code);
    }
}
