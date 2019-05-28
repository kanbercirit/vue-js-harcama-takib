<?php

use Slim\App;

return function (App $app) {
    // e.g: $app->add(new \Slim\Csrf\Guard);
    $tarih = new \DateTime('now');
    $tarihStr = $tarih->format('Y m d');
    $app->add(new \Tuupola\Middleware\JwtAuthentication([
        "path" => "/api", /* or ["/api", "/admin"] */
        "attribute" => "decoded_token_data",
        "secret" => "<6@)mGjB,qQ2'gld)G;%]yfji]Q%1Hx)?U7ac3=7!.@,UK]IPrxe>T4Z<(<3H[)" . $tarihStr,
        "algorithm" => ["HS256"],
        "error" => function ($response, $arguments) {
            $data["Netice"] = "Hata!";
            $data["Mesaj"] = $arguments["message"];
            return $response
                ->withHeader("Content-Type", "application/json")
                ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        },
    ]));

};
