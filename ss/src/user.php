<?php
use Slim\Http\Request;
use Slim\Http\Response;

$app->get('/user', function (Request $request, Response $response, array $args) use ($sabitler) {
    $decoded_token_data = $request->getAttribute('decoded_token_data');
    $email = $decoded_token_data["email"];
    
    $user = $this->db->query(
        "SELECT OKytNo, KaydTarihi, GuncellemeTarihi, isim, soyisim, email FROM Kullanicilar WHERE email= :email",
        array("email" => $email));
    if (!$user) {
        return $this->response->withJson([$sabitler->koddanGetir("Netice") => $sabitler->koddanGetir("Hata"), $sabitler->koddanGetir("Mesaj") => 'These credentials do not match our records..']);
    }
    
    return $this->response->withJson([
        $sabitler->koddanGetir("Netice") => $sabitler->koddanGetir("Tamam"),
        $sabitler->koddanGetir("Veriler") => $user]);

});
