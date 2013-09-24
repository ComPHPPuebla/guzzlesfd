<?php
require 'vendor/autoload.php';

use \Guzzle\Http\Client;

$client = new Client('http://www.comunidadphppuebla.com');
$request = $client->get('/comunidad');

echo $request->getUrl();

$response = $request->send();

echo $response->getBody();