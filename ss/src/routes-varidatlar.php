<?php
$app->get('/mevcudatNeviGetir', function ($request, $response, $args) {
    $netice = [NevGetir('MevcudatNevleri', 1, $this)];
    return $this->response->withJson($netice);
});

function mevcudatGetir($pOKytNo)
{
    return tablodanKayitlariGetir($app, ' Mevcudat ', '*', 'OKytNo = '. $pOKytNo);
}

$app->get('/mevcudatYekunu/{ilkTarih}/{sonTarih}', function ($request, $response, $args) {
    $netice = NeticeOlustur(BlokDisi, Hata, []);
    try {
        $Mevcudat = $this->db->query(
            "SELECT IFNULL(Sum(Mikdar), 0) As Yekun
            FROM Mevcudat
            Where Tarih Between :ilkTarih And :sonTarih",
            array("ilkTarih" => $args['ilkTarih'], "sonTarih" => $args['sonTarih']));
        $netice = NeticeOlustur(Tamam, Veriler, $Mevcudat);        
    } catch (Exception $e) {
        $netice = NeticeOlustur(Hata, Hata, $e->getMessage());
    } finally {
        return $this->response->withJson($netice);
    }
});

$app->get('/mevcudat/{ilkTarih}/{sonTarih}', function ($request, $response, $args) {
    //return $response->write("Hello " . $args['ilkTarih']. ' ' . $args['sonTarih']);
    $netice = NeticeOlustur(BlokDisi, Hata, []);
    try {
        $Mevcudat = $this->db->query(
            "SELECT OKytNo, KaydTarihi, modification_time, Tarih, (Select NevIsmi From MevcudatNevleri Where OKytNo = RbtNevler) As Nev, RbtNevler, Mikdar, Izah,
             (Select SiraNo From MevcudatNevleri Where OKytNo = RbtNevler) As SiraNo
            FROM Mevcudat
            Where Tarih Between :ilkTarih And :sonTarih
            Order By SiraNo",
            array("ilkTarih" => $args['ilkTarih'], "sonTarih" => $args['sonTarih']));
        $netice = NeticeOlustur(Tamam, Veriler, $Mevcudat);        
    } catch (Exception $e) {
        $netice = NeticeOlustur(Hata, Hata, $e->getMessage());
    } finally {
        return $this->response->withJson($netice);
    }
});

$app->put('/mevcudat', function ($request, $response, $args) {
    $input = $request->getParsedBody();
    $netice = NeticeOlustur(BlokDisi, Hata, []);
    try {
        $eklenenKayitAdedi = $this->db->query(
            "Update Mevcudat 
             Set Tarih = :Tarih, RbtNevler = :RbtNevler, 
             Mikdar = :Mikdar, Izah = :Izah
             Where OKytNo = :OKytNo",
            array("Tarih" => $input['Tarih'], "RbtNevler" => $input['RbtNevler'],
                "Mikdar" => $input['Mikdar'], "Izah" => $input['Izah'], "OKytNo" => $input['OKytNo']));        
        $input['Nev'] = NevGetir(' MevcudatNevleri ', $input['RbtNevler'], $this);        
        $netice = NeticeOlustur(Tamam, Veriler, $input);
    } catch (Exception $e) {
        $netice = NeticeOlustur(Hata, Hata, $e->getMessage());
    } finally {
        return $this->response->withJson($netice);
    }
});

$app->post('/mevcudat', function ($request, $response, $args) {
    $input = $request->getParsedBody();
    $netice = NeticeOlustur(BlokDisi, Hata, []);
    try {
        $eklenenKayitAdedi = $this->db->query("Insert Into Mevcudat (Tarih, RbtNevler, Mikdar, Izah) VALUES(:Tarih,:RbtNevler, :Mikdar, :Izah)",
            array("Tarih" => $input['Tarih'], "RbtNevler" => $input['RbtNevler'],
                "Mikdar" => $input['Mikdar'], "Izah" => $input['Izah']));
        //Bak bunu hemen al. Başka bir işlem yaptıktan sonra alıyorsun, sonra 0 geliyor.
        $input['OKytNo'] = $this->db->sonEklenenKayitNoGetir();
        $input['Nev'] = NevGetir(' MevcudatNevleri ', $input['RbtNevler'], $this);        
        $netice = NeticeOlustur(Tamam, Veriler, $input);
    } catch (Exception $e) {
        $netice = NeticeOlustur(Hata, Hata, $e->getMessage());
    } finally {
        return $this->response->withJson($netice);
    }
});

$app->delete('/mevcudat/{OKytNo}', function ($request, $response, $args) {
    $OKytNo = $args['OKytNo'];
    $netice = NeticeOlustur(BlokDisi, Hata, []);
    try {        
        $silinenKayitAdedi = $this->db->query(
            "Delete From Mevcudat
             Where OKytNo = :OKytNo",
            array("OKytNo" => $OKytNo));
        $netice = NeticeOlustur(Tamam, Veriler, ["OKytNo" => $OKytNo,
        "SilinenKayitAdedi"=>$silinenKayitAdedi]);        
    } catch (Exception $e) {
        $netice = NeticeOlustur(Hata, Hata, $e->getMessage());
    } finally {
        return $this->response->withJson($netice);
    }    
});

$app->get('/mevcudatnevleri', function ($request, $response, $args) {
    $mevcudatnevleri = $this->db->query("SELECT * FROM MevcudatNevleri Order By OKytNo");
    return $this->response->withJson([$mevcudatnevleri]);
});