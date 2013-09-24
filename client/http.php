<?php
require '../vendor/autoload.php';

use \Guzzle\Http\Client;
use Faker\Factory;

$faker = Factory::create();

$client = new Client('http://localhost/comphppuebla/guzzle/api');

$acceptJson = ['Accept' => 'application/json'];
$acceptXml = ['Accept' => 'application/xml'];

$request = $client->get('contacts/1', $acceptXml);

$response = $request->send();

echo "\nGET /contacts/1\n";
echo $response->getBody();

$contact = ['name' => $faker->firstName, 'last_name' => $faker->lastName];

$request = $client->post('contacts', $acceptJson, http_build_query($contact));

$response = $request->send();

echo "\n\nPOST /contacts\n";
echo $response->getBody();

$newName = $faker->firstName;

$contact = ['name' => $newName];

$request = $client->put('contacts/2', $acceptXml, http_build_query($contact));

$response = $request->send();

echo "\n\nPUT /contacts/2 (New name is {$newName})\n";
echo $response->getBody();
echo "Last modified time: {$response->getLastModified()}";

$request = $client->delete('contacts/3');

$response = $request->send();

echo "\n\nDELETE /contacts/3\n";
echo "Status code: {$response->getStatusCode()}";

$request = $client->options('contacts/4');

$response = $request->send();

echo "\n\nOPTIONS /contacts/4\n";
echo "Valid methods are: {$response->getAllow()}";