<?php
include('fsession.php');
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$userMessages = $data['messages'] ?? [];

if(empty($userMessages)){
    echo json_encode(["error"=>["message"=>"No messages received"]]);
    exit();
}

/* AI Personality */
$systemPrompt = [
    "role" => "system",
    "content" => "You are SmartKrushi AI, an agriculture expert helping Indian farmers with crops, soil, irrigation, fertilizer, and pest control."
];

array_unshift($userMessages,$systemPrompt);

/* YOUR OPENAI API KEY */
$apiKey = "YOUR_OPENAI_API_KEY_HERE";

/* API Request */
$payload = [
    "model" => "gpt-4o-mini",
    "messages" => $userMessages
];

$ch = curl_init("https://api.openai.com/v1/chat/completions");

curl_setopt_array($ch,[
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "Authorization: Bearer ".$apiKey
    ],
    CURLOPT_POSTFIELDS => json_encode($payload)
]);

$response = curl_exec($ch);

if(curl_errno($ch)){
    echo json_encode([
        "error"=>[
            "message"=>"Curl Error: ".curl_error($ch)
        ]
    ]);
}else{
    echo $response;
}

curl_close($ch);
?>
