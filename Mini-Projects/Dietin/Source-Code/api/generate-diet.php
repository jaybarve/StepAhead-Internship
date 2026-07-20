<?php
// api/generate-diet.php
session_start();
header('Content-Type: application/json');
require_once 'ai_analyze.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_SESSION['diet_result'])) {
        echo json_encode(["success" => true, "data" => $_SESSION['diet_result']]);
    } else {
        echo json_encode(["success" => false, "message" => "No analysis session found."]);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $input = json_decode($json, true);

    if (!$input) {
        echo json_encode(["success" => false, "message" => "Invalid parameters provided."]);
        exit;
    }

    $budget = htmlspecialchars($input['budget'] ?? '1500');
    $goal = htmlspecialchars($input['goal'] ?? 'Healthy Lifestyle');
    $dietPref = htmlspecialchars($input['dietPreference'] ?? 'Vegetarian');
    $likes = is_array($input['likes']) ? implode(', ', $input['likes']) : htmlspecialchars($input['likes']);

    $prompt = "You are an AI nutritionist. Generate a 7-day meal schedule and matching grocery cart:
    - Weekly Budget: INR $budget
    - Goal: $goal
    - Diet Preference: $dietPref
    - Preferred Foods: $likes

    Return strictly formatted valid JSON matching this schema:
    {
      \"nutritionSummary\": {
        \"calories\": 2100,
        \"protein\": \"110g\",
        \"carbs\": \"240g\"
      },
      \"totalEstimatedCost\": 1420,
      \"mealSchedule\": [
        {
          \"day\": \"Monday\",
          \"meals\": [
            {\"name\": \"Breakfast\", \"items\": \"Oatmeal with Almonds\", \"calories\": 420},
            {\"name\": \"Lunch\", \"items\": \"Paneer Rice Bowl\", \"calories\": 680},
            {\"name\": \"Dinner\", \"items\": \"Lentil Soup with Roti\", \"calories\": 520}
          ]
        }
      ],
      \"groceryCart\": [
        {\"item\": \"Rolled Oats (1kg)\", \"quantity\": \"1 pack\", \"estimatedCost\": 180}
      ]
    }";

    $response = callGeminiAPI($prompt);

    if (isset($response['success'])) {
        $_SESSION['diet_result'] = $response['data'];
        echo json_encode(["success" => true, "data" => $response['data']]);
    } else {
        echo json_encode(["success" => false, "message" => $response['error']]);
    }
    exit;
}
