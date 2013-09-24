<?php
require '../vendor/autoload.php';

use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;
use Guzzle\Log\MessageFormatter;
use Guzzle\Log\MonologLogAdapter;
use Guzzle\Plugin\Log\LogPlugin;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Faker\Factory;

$faker = Factory::create();

$client = new Client();
$client->setDescription(ServiceDescription::factory('../config/config.json'));

$logger = new Logger('debug');
$logger->pushHandler(new StreamHandler('../logs/debug.log'));
$logPlugin = new LogPlugin(new MonologLogAdapter($logger), MessageFormatter::DEBUG_FORMAT);

$client->addSubscriber($logPlugin);

$contact = $client->showContact(['contactId' => 1, 'accept' => 'application/json']);

echo "\nShow contact information {$contact['name']} {$contact['last_name']}\n";

$newContact = ['name' => $faker->firstName, 'lastName' => $faker->lastName];

$contact = $client->newContact(array_merge($newContact, ['accept' => 'application/xml']));

echo <<<MESSAGE
\nNew contact information {$contact['name']} {$contact['last_name']} with ID {$contact['contact_id']}\n
MESSAGE;

$newName = $faker->firstName;

$contact = $client->editContact([
	'contactId' => 2, 'name' => $newName, 'accept' => 'application/json'
]);

echo <<<MESSAGE
\nEdit name {$newName}. Updated contact information: {$contact['name']} {$contact['last_name']} with ID {$contact['contact_id']}\n
MESSAGE;

$response = $client->deleteContact(['contactId' => 3]);

echo <<<MESSAGE
\nDeleting contact with ID 3. Status code: {$response->getStatusCode()}, {$response->getReasonPhrase()}\n
MESSAGE;
