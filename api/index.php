<?php
require '../vendor/autoload.php';

use Negotiation\Negotiator;
use Faker\Factory;
use Slim\Slim;
use Slim\Views\Twig;

$app = new Slim();
$app->config('templates.path', '../views');
$app->view(new Twig());
$app->faker = Factory::create();

$contentNegotiation = function() use ($app) {
	$negotiator = new Negotiator();

	$format = $negotiator->getBest($app->request()->headers('Accept'));
	$type = $format->getValue();

	$app->contentType($type);

	$app->template = 'contacts/show.json.twig';
	if ('application/xml' ===  $type) {

		$app->template = 'contacts/show.xml.twig';
	}
};

$app->post('/contacts', $contentNegotiation, function() use ($app) {

	$contactInformation = $app->request()->getBody();

	parse_str($contactInformation, $contact);

	$contact['contact_id'] = $app->faker->randomDigit; //Simulate an insert

	$app->status(201);

	echo $app->render($app->template, ['contact' => $contact]);
});

$app->get('/contacts/:id', $contentNegotiation, function($id) use($app) {

	//This value should be specific to the current resource
	$lastModifiedTime = gmdate('D, d M Y H:i:s ') . ' GMT';

	$app->response()->header('Last-Modified', $lastModifiedTime);
	$app->status(200);

	echo $app->render($app->template, [
		'contact' => [
			'contact_id' => $id, 'name' => $app->faker->firstName, 'last_name' => $app->faker->lastName,
		],
	]);
});

$app->put('/contacts/:id', $contentNegotiation, function($id) use($app) {

	$contactInformation = $app->request()->getBody();

	parse_str($contactInformation, $contact);

	$contact['contact_id'] = $id;
	if (empty($contact['name'])) {

		$contact['name'] = $app->faker->firstName;
	}

	if (empty($contact['last_name'])) {

		$contact['last_name'] = $app->faker->lastName;
	}

	$lastModifiedTime = time();

	$app->lastModified($lastModifiedTime);
	$app->status(200);

	echo $app->render($app->template, ['contact' => $contact]);
});

$app->delete('/contacts/:id', function($id) use($app) {

	//Delete contact here
	$app->status(204);
});

$app->options('/contacts/:id', function($id) use ($app) {
	$validOptions = ['GET', 'HEAD', 'PUT', 'DELETE', 'OPTIONS'];

	$app->response()->header('Allow', implode(',', $validOptions));
});

$app->run();