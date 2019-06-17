<?php
use Slim\Http\Request;
use Slim\Http\Response;
use \Firebase\JWT\JWT;

$app->post('/login', function (Request $request, Response $response, array $args) use ($sabitler) {
    $input = $request->getParsedBody();
    //echo $input['email'];
    $user = $this->db->query(
        "SELECT * FROM Kullanicilar WHERE email= :email",
        array("email" => $input['email']));
    if (!$user) {
        return $this->response->withJson([$sabitler->koddanGetir("Netice") => $sabitler->koddanGetir("Hata"), $sabitler->koddanGetir("Mesaj") => 'These credentials do not match our records..']);
    }
    if (!password_verify($input['sifre'], $user[0]["sifre"])) {
        return $this->response->withJson([$sabitler->koddanGetir("Netice") => $sabitler->koddanGetir("Hata"), $sabitler->koddanGetir("Mesaj") => 'These credentials do not match our records.']);
    }
    $settings = $this->get('settings');
    $token = JWT::encode(['id' => $user[0]["OKytNo"], 'email' => $user[0]["email"]], $settings['jwt']['secret'], "HS256");
    return $this->response->withJson([
        $sabitler->koddanGetir("Netice") => $sabitler->koddanGetir("Tamam"),
        $sabitler->koddanGetir("Token") => $token,
        "OKytNo" => $user[0]["email"]]);
});
