<?php
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

require __DIR__ . "/access.php";
require __DIR__ . "/../asg/ensar/sabitler.php";
require __DIR__ . "/ensar-harcama.php";
require __DIR__ . '/../asg/ensar/netice_kodlari.php';
require __DIR__ . '/../asg/auth/auth.php';
require __DIR__ . '/../asg/db/Db.class.php';

return function (App $app) {
    //echo "Ali gel.";
    $container = $app->getContainer();
    $sabitler = new Sabitler();
    $c = $app->getContainer();
    $container['notAllowedHandler'] = function ($container) {
        return function ($request, $response, $methods) use ($container) {
            return $response->withStatus(405)
                ->withHeader('Allow', implode(', ', $methods))
                ->withHeader('Content-type', 'text/html')
                ->write('Method must be one of: ' . implode(', ', $methods));
        };
    };

    $app->get('/', function (Request $request, Response $response, array $args) {
        return $this->response->withJson(['Netice' => "Çalıştı."]);
    });

    require __DIR__ . "/login.php";

    $app->group('/api', function (\Slim\App $app) {
        $sabitler = new Sabitler();
        require __DIR__ . "/routes-umumi.php";
        require __DIR__ . "/routes-harcamalar.php";
        require __DIR__ . "/routes-gelirler.php";
        require __DIR__ . "/routes-varidatlar.php";
        require __DIR__ . "/user.php";
        $sabitler = null;
    });
    $sabitler = null;
};

require __DIR__ . "/map.php";
