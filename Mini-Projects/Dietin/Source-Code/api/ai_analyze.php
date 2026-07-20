<?php
// api/ai_analyze.php

function callGeminiAPI($promptText) {
    $apiKey = "AQ.Ab8RN6Ke05_P_WFtzblj_Wt6t4eMn22wLIc7IsHEcuTsmkwOiQ";
    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . $apiKey;

    $payload = [
        "contents" => [
            [
                "parts" => [
                    ["text" => $promptText]
                ]
            ]
        ],
        "generationConfig" => [
            "response_mime_type" => "application/json"
        ]
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch)) {
        $errorMsg = curl_error($ch);
        curl_close($ch);
        return ["error" => "cURL Error: " . $errorMsg];
    }

    curl_close($ch);

    if ($httpCode !== 200) {
        return ["error" => "API Request failed with HTTP status code " . $httpCode];
    }

    $decoded = json_decode($response, true);
    $textResult = $decoded['candidates'][0]['content']['parts'][0]['text'] ?? null;

    if ($textResult) {
        $parsedJson = json_decode($textResult, true);
        if ($parsedJson) {
            return ["success" => true, "data" => $parsedJson];
        }
    }

    return ["error" => "Invalid JSON payload structure returned by Gemini."];
}
