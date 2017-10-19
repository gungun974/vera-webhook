<?php

$method = $_SERVER['REQUEST_METHOD'];

// Process only when method is POST
if ($method === "POST") {
    $requestBody = file_get_contents('php://input');
    $json = json_decode($requestBody);

    $light_name = $json->result->parameters->light_name;

    $response = new stdClass();

    switch ($json->result->action) {
    	case 'TurnOn':
	    	$ch = curl_init(); 
	        curl_setopt($ch, CURLOPT_URL, "http://165.169.52.244:3480/data_request?id=action&output_format=json&serviceId=urn:upnp-org:serviceId:SwitchPower1&action=SetTarget&newTargetValue=1&DeviceNum=40"); 
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	        $output = curl_exec($ch); 
	        curl_close($ch);      
		    $response->speech = "J'allumere la lumière " . $light_name;
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