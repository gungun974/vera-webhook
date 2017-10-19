<?php

$method = $_SERVER['REQUEST_METHOD'];

// Process only when method is POST
if ($method === "POST") {
    $requestBody = file_get_contents('php://input');
    $json = json_decode($requestBody);

    $light_name = $json->result->parameters->light_name;
    $response = new stdClass();

    switch ($json->action) {
    	case 'TurnOn':
		    $response->speech = "J'allumerer la lumière " . $light_name . " dans 2000 ans ou vous me donnée 1000€ dans mon paypale : ha ha ha c'est une blage";
		    $response->source = "vera-webhook";
    		break;
    	
    	default:
		    $response->speech = "Bonjour je suis VERA !!!";
		    $response->source = "vera-webhook";
    }
    echo json_encode($response);
} else {
    echo "Method not allowed";
}