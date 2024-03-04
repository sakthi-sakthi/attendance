<?php
header("Access-Control-Allow-Origin: *");  // Adjust as needed
header("Content-Type: application/json");

// Get data from the client-side request
$data = json_decode(file_get_contents("php://input"));

// Make a request to Nexmo API
$ch = curl_init("https://api.nexmo.com/v0.1/messages");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

$response = curl_exec($ch);

// Close cURL resource
curl_close($ch);

// Return Nexmo API response to the client-side
echo $response;
?>