<?php

$method = $_SERVER['REQUEST_METHOD'];

// Process only when method is POST
if ($method === "POST") {
    $requestBody = file_get_contents('php://input');
    $json = json_decode($requestBody);

    $text = $json->result->parameters->text;

    $response = new stdClass();
    $response->mesage = [
    	"type" => 0,
    	"speach" => "Bonjour je suis vera"
    ];
    $response->source = "vera-webhook";
    echo json_encode($response);
} else {
    echo "Method not allowed";
}