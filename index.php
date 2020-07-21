<?php

use Symfony\Component\Dotenv\Dotenv;
use Tqdev\PhpCrudApi\Api;
use Tqdev\PhpCrudApi\Config;
use Tqdev\PhpCrudApi\RequestFactory;
use Tqdev\PhpCrudApi\ResponseUtils;

require_once __DIR__ . "/vendor/autoload.php";

$dotenv = new Dotenv('PCA_ENV', 'PCA_DEBUG');
$dotenv->loadEnv(__DIR__ . "/.env");

$config = [
    'driver' => $_ENV['PCA_DRIVER'],
    'address' => $_ENV['PCA_HOST'],
    'username' => $_ENV['PCA_USERNAME'],
    'password' => $_ENV['PCA_PASSWORD'],
    'database' => $_ENV['PCA_DATABASE'],
    'debug' => $_ENV['PCA_DEBUG']
];

if(isset($_ENV['PCA_PORT'])) {
  $config['port'] = $_ENV['PCA_PORT'];
}

$configPaths = glob("./config/*.php");
foreach($configPaths as $configPath) {
  $config += require $configPath;
}

$request = RequestFactory::fromGlobals();
$api = new Api(new Config($config));
$response = $api->handle($request);
ResponseUtils::output($response);

