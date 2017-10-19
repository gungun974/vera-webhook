<?php

$config = [
	'bureau' => [
		'type' => 'light',
		'id' => 40
	]
];

$VERA_IP = "165.169.52.244";
$VERA_PORT = 3480;

$method = $_SERVER['REQUEST_METHOD'];

// Process only when method is POST
if ($method === "POST") {
    $requestBody = file_get_contents('php://input');
    $json = json_decode($requestBody);

    $name = $json->result->parameters->name;

    $response = new stdClass();
    $response->source = "vera-webhook";

    switch ($json->result->action) {
        case 'TurnOn':
            if (!is_null($config[$name])) {
                if ($config[$name]['type'] == "light") {
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, "http://{$VERA_IP}:{$VERA_PORT}/data_request?id=action&output_format=json&serviceId=urn:upnp-org:serviceId:SwitchPower1&action=SetTarget&newTargetValue=1&DeviceNum={$config[$name]['id']}");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    $output = curl_exec($ch);
                    curl_close($ch);
                    $response->speech = "J'allume la lumière " . $name;
                } else {
                    $response->speech = "Excuser moi mais " . $name . " n'est pas une lumière";
                }
            } else {
                $response->speech = "Excuser moi mais la lumière " . $name . " n'est pas valide";
            }
            break;

        case 'TurnOff':
            if (!is_null($config[$name])) {
                if ($config[$name]['type'] == "light") {
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, "http://{$VERA_IP}:{$VERA_PORT}/data_request?id=action&output_format=json&serviceId=urn:upnp-org:serviceId:SwitchPower1&action=SetTarget&newTargetValue=0&DeviceNum={$config[$name]['id']}");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    $output = curl_exec($ch);
                    curl_close($ch);
                    $response->speech = "J'éteint la lumière " . $name;
                } else {
                    $response->speech = "Excuser moi mais " . $name . " n'est pas une lumière";
                }
            } else {
                $response->speech = "Excuser moi mais la lumière " . $name . " n'est pas valide";
            }
            break;
    	
    	default:
		    $response->speech = $json->result->action;
    }
    echo json_encode($response);
} else {
    echo "Method not allowed";
}