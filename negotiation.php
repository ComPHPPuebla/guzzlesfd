<?php
require 'vendor/autoload.php';

// Replace /comphppuebla/guzzle for the path to your negotiation.php file to try this route.
// curl --header "Accept: application/xml" http://localhost/comphppuebla/guzzle/negotiation.php

use Negotiation\Negotiator;
use Faker\Factory;
use Twig_Loader_Filesystem as FilesystemLoader;
use Twig_Environment as Environment;

$negotiator = new Negotiator();

$headers = getallheaders();

$format = $negotiator->getBest($headers['Accept']);
$type = $format->getValue();

$template = 'contacts/show.json.twig';
if ('application/xml' ===  $type) {

	$template = 'contacts/show.xml.twig';
}

$loader = new FilesystemLoader('views');
$environment = new Environment($loader);

$faker = Factory::create();

echo $environment->render($template, [
	'contact' => [
		'contact_id' => $faker->randomDigit, 'name' => $faker->name, 'last_name' => $faker->lastName,
	]
]);