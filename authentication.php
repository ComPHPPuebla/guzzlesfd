<?php
// Replace /comphppuebla/guzzle for the path to your negotiation.php file to try this file.
// curl -u luis:ingresar http://localhost/comphppuebla/guzzle/authentication.php
$headers = getallheaders();
$authenticationHeaderParts = explode(' ', $headers['Authorization']);

$encodedCredentials = array_pop($authenticationHeaderParts);

$credentials = base64_decode(trim($encodedCredentials));

$credentials = explode(':', $credentials);

echo "Logged in as {$credentials[0]} with password {$credentials[1]}";