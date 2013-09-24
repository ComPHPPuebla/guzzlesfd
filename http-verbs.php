<?php
require 'vendor/autoload.php';

use Slim\Slim;

$app = new Slim();

// Replace /comphppuebla/guzzle for the path to your http-verbs.php file to try this route.
// curl -X GET http://localhost/comphppuebla/guzzle/contacts/1
$app->get('/contacts/:id', function($id) {

	echo "Request via GET with ID = $id";
});

// Replace /comphppuebla/guzzle for the path to your http-verbs.php file to try this route.
// curl -X POST http://localhost/comphppuebla/guzzle/contacts
$app->post('/contacts', function() {

	echo "Request via POST";
});

// Replace /comphppuebla/guzzle for the path to your http-verbs.php file to try this route.
// curl -X PUT http://localhost/comphppuebla/guzzle/contacts/2
$app->put('/contacts/:id', function($id) {

	echo "Request via PUT with ID = $id";
});

// Replace /comphppuebla/guzzle for the path to your http-verbs.php file to try this route.
// curl -X DELETE http://localhost/comphppuebla/guzzle/contacts/3
$app->delete('/contacts/:id', function($id) {

	echo "Request via DELETE with ID = $id";
});

// Replace /comphppuebla/guzzle for the path to your http-verbs.php file to try this route.
// curl -X OPTIONS http://localhost/comphppuebla/guzzle/contacts/4
$app->options('/contacts/:id', function($id) {

	echo "Request via OPTIONS with ID = $id";
});

$app->run();