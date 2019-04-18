<?php
$app->get('/umumiYekun/{ilkTarih}/{sonTarih}', function ($request, $response, $args) {
    $netice = NeticeOlustur(BlokDisi, Hata, []);
    try {
        $varidatlar = $this->db->query(
          "Select * ,  (gelirlerYekunu - harcamalarYekunu - MevcudatYekunu) * -1 As Netice From
            (Select 
              (SELECT IFNULL(Sum(Mikdar), 0) As Yekun FROM Gelirler   Where Tarih Between :ilkTarih1 And :sonTarih1)As gelirlerYekunu,
              (SELECT IFNULL(Sum(Mikdar), 0) As Yekun FROM Harcamalar Where Tarih Between :ilkTarih2 And :sonTarih2)As harcamalarYekunu,
              (SELECT IFNULL(Sum(Mikdar), 0) As Yekun FROM Mevcudat Where Tarih Between :ilkTarih3 And :sonTarih3)As MevcudatYekunu
            ) As DisTablo ",              
            array(
            "ilkTarih1" => $args['ilkTarih'], "sonTarih1" => $args['sonTarih'],
            "ilkTarih2" => $args['ilkTarih'], "sonTarih2" => $args['sonTarih'],
            "ilkTarih3" => $args['ilkTarih'], "sonTarih3" => $args['sonTarih'],
        ));
        $netice = NeticeOlustur(Tamam, Veriler, $varidatlar);        
    } catch (Exception $e) {
        $netice = NeticeOlustur(Hata, Hata, $e->getMessage());
    } finally {
        return $this->response->withJson($netice);
    }
});
