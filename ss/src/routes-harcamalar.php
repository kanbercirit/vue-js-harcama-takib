<?php
$app->get('/harcamaNeviGetir', function ($request, $response, $args) {
    $netice = [NevGetir('HarcamaNevleri', 1, $this)];
    return $this->response->withJson($netice);
});

function harcamaGetir($pOKytNo)
{
    return tablodanKayitlariGetir($app, ' Harcamalar ', '*', 'OKytNo = ' . $pOKytNo);
}

$app->get('/harcamalarYekunu/{ilkTarih}/{sonTarih}', function ($request, $response, $args) {
    $netice = NeticeOlustur(BlokDisi, Hata, []);
    try {
        $harcamalar = $this->db->query(
            "SELECT IFNULL(Sum(Mikdar), 0) As Yekun
            FROM Harcamalar
            Where Tarih Between :ilkTarih And :sonTarih",
            array("ilkTarih" => $args['ilkTarih'], "sonTarih" => $args['sonTarih']));
        $netice = NeticeOlustur(Tamam, Veriler, $harcamalar);
    } catch (Exception $e) {
        $netice = NeticeOlustur(Hata, Hata, $e->getMessage());
    } finally {
        return $this->response->withJson($netice);
    }
});

$app->get('/harcamalar-tecrube/{ilkTarih}/{sonTarih}', function ($request, $response, $args) {
    return $response->write("Merhaba, İlk Tarih: " . $args['ilkTarih'] . '  Son Tarih: ' . $args['sonTarih']);
});

$app->get('/harcamalar/{ilkTarih}/{sonTarih}', function ($request, $response, $args) {
    //return $response->write("Hello " . $args['ilkTarih']. ' ' . $args['sonTarih']);
    $netice = NeticeOlustur(BlokDisi, Hata, []);
    try {
        $harcamalar = $this->db->query(
            "SELECT OKytNo, KaydTarihi, modification_time, Tarih, (Select NevIsmi From HarcamaNevleri Where OKytNo = RbtNevler) As Nev, RbtNevler, Mikdar, Izah
            FROM Harcamalar
            Where Tarih Between :ilkTarih And :sonTarih
            Order By Tarih Desc, OKytNo Desc",
            array("ilkTarih" => $args['ilkTarih'], "sonTarih" => $args['sonTarih']));
        $netice = NeticeOlustur(Tamam, Veriler, $harcamalar);
    } catch (Exception $e) {
        $netice = NeticeOlustur(Hata, Hata, $e->getMessage());
    } finally {
        return $this->response->withJson($netice);
    }
});

$app->put('/harcama', function ($request, $response, $args) {
    $input = $request->getParsedBody();
    $netice = NeticeOlustur(BlokDisi, Hata, []);
    try {
        $eklenenKayitAdedi = $this->db->query(
            "Update Harcamalar
             Set Tarih = :Tarih, RbtNevler = :RbtNevler,
             Mikdar = :Mikdar, Izah = :Izah
             Where OKytNo = :OKytNo",
            array("Tarih" => $input['Tarih'], "RbtNevler" => $input['RbtNevler'],
                "Mikdar" => $input['Mikdar'], "Izah" => $input['Izah'], "OKytNo" => $input['OKytNo']));
        $input['Nev'] = NevGetir(' HarcamaNevleri ', $input['RbtNevler'], $this);
        $netice = NeticeOlustur(Tamam, Veriler, $input);
    } catch (Exception $e) {
        $netice = NeticeOlustur(Hata, Hata, $e->getMessage());
    } finally {
        return $this->response->withJson($netice);
    }
});

$app->post('/harcama', function ($request, $response, $args) {
    $input = $request->getParsedBody();
    $netice = NeticeOlustur(BlokDisi, Hata, []);
    try {
        $eklenenKayitAdedi = $this->db->query("Insert Into Harcamalar (Tarih, RbtNevler, Mikdar, Izah) VALUES(:Tarih,:RbtNevler, :Mikdar, :Izah)",
            array("Tarih" => $input['Tarih'], "RbtNevler" => $input['RbtNevler'],
                "Mikdar" => $input['Mikdar'], "Izah" => $input['Izah']));
        //Bak bunu hemen al. Başka bir işlem yaptıktan sonra alıyorsun, sonra 0 geliyor.
        $input['OKytNo'] = $this->db->sonEklenenKayitNoGetir();
        $input['Nev'] = NevGetir(' HarcamaNevleri ', $input['RbtNevler'], $this);
        $netice = NeticeOlustur(Tamam, Veriler, $input);
    } catch (Exception $e) {
        $netice = NeticeOlustur(Hata, Hata, $e->getMessage());
    } finally {
        return $this->response->withJson($netice);
    }
});

$app->delete('/harcama/{OKytNo}', function ($request, $response, $args) {
    $OKytNo = $args['OKytNo'];
    $netice = NeticeOlustur(BlokDisi, Hata, []);
    try {
        $silinenKayitAdedi = $this->db->query(
            "Delete From Harcamalar
             Where OKytNo = :OKytNo",
            array("OKytNo" => $OKytNo));
        $netice = NeticeOlustur(Tamam, Veriler, ["OKytNo" => $OKytNo,
            "SilinenKayitAdedi" => $silinenKayitAdedi]);
    } catch (Exception $e) {
        $netice = NeticeOlustur(Hata, Hata, $e->getMessage());
    } finally {
        return $this->response->withJson($netice);
    }
});

$app->delete('/harcama', function ($request, $response, $args) {
    //$input = $request->getParsedBody().OKytNo;
    $OKytNo = $request->getParsedBody()["OKytNo"];
    $netice = NeticeOlustur(BlokDisi, Hata, []);
    try {
        $silinenKayitAdedi = $this->db->query(
            "Delete From Harcamalar
             Where OKytNo = :OKytNo",
            array("OKytNo" => $OKytNo));
        $netice = NeticeOlustur(Tamam, Veriler, ["OKytNo" => $OKytNo,
            "SilinenKayitAdedi" => $silinenKayitAdedi]);
    } catch (Exception $e) {
        $netice = NeticeOlustur(Hata, Hata, $e->getMessage());
    } finally {
        return $this->response->withJson($netice);
    }
});

$app->get('/harcamanevleri', function ($request, $response, $args) {
    $harcamanevleri = $this->db->query("SELECT * FROM HarcamaNevleri");
    return $this->response->withJson([$harcamanevleri]);
});
