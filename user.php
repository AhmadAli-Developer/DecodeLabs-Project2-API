<?php
// =========================================================================
// DECODELABS INTERNSHIP - PROJECT 2: BACKEND API DEVELOPMENT
// Architecture: RESTful REST API (Stateless & JSON-Driven)
// Developer: Ahmad Ali
// Exact File Path: C:/xampp/htdocs/Portfolio-API/user.php
// =========================================================================

// Global Headers Configuration (Bridging the Synaptic Gap Layer)
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");

// Capturing the incoming HTTP Verb/Method
$method = $_SERVER['REQUEST_METHOD'];

// -------------------------------------------------------------------------
// 1. GET METHOD LAYER (Data Retrieval Pipeline)
// -------------------------------------------------------------------------
if ($method === 'GET') {
    
    // Core Data Structure (The Healthy Organism Paradigm - Resources as Nouns)
    $dummy_user_profile = [
        [
            "id" => 1,
            "name" => "Ahmad Ali",
            "role" => "Full-Stack Developer Intern",
            "institution" => "The Superior University Lahore",
            "current_sprint" => "Project 2 (Backend API Engineering)",
            "skills" => ["HTML5", "CSS3", "JavaScript", "Bootstrap 5", "PHP", "REST APIs"],
            "completed_milestone" => "Project 1: Modern Premium Portfolio UI"
        ]
    ];

    // Emitting 200 OK Response Code
    http_response_code(200);
    
    // Encoding standard payload into strict JSON Output
    echo json_encode([
        "status" => "success",
        "message" => "User profile and architectural data retrieved successfully via GET.",
        "server_processing_mode" => "Stateless/Array-Memory",
        "data" => $dummy_user_profile
    ], JSON_PRETTY_PRINT);
}

// -------------------------------------------------------------------------
// 2. POST METHOD LAYER (Data Ingestion, Schema Validation & Processing)
// -------------------------------------------------------------------------
elseif ($method === 'POST') {
    
    // Capturing raw JSON request body stream from the client input path
    $raw_input = file_get_contents("php://input");
    
    // Decoding the JSON payload into an associative PHP array
    $input_data = json_decode($raw_input, true);

    // Strict Evaluation & Validation Logic (Input Guard-Rails)
    if (
        empty($input_data['name']) || 
        trim($input_data['name']) === "" ||
        empty($input_data['email']) || 
        trim($input_data['email']) === "" ||
        empty($input_data['message']) || 
        trim($input_data['message']) === ""
    ) {
        // Validation Failed: Emitting 400 Bad Request Status
        http_response_code(400);
        
        echo json_encode([
            "status" => "error",
            "error_type" => "SCHEMA_VALIDATION_FAILURE",
            "message" => "Validation Failed: 'name', 'email', and 'message' fields are strictly mandatory.",
            "remediation" => "Ensure the raw request JSON payload contains all three key-value slots fully populated."
        ], JSON_PRETTY_PRINT);
        
    } else {
        // Validation Passed: Data sanitized against XSS attacks before echo processing
        $sanitized_name = htmlspecialchars(strip_tags(trim($input_data['name'])));
        $sanitized_email = filter_var(trim($input_data['email']), FILTER_SANITIZE_EMAIL);
        $sanitized_message = htmlspecialchars(strip_tags(trim($input_data['message'])));

        // Emitting 201 Created/Processed Success Status Code
        http_response_code(201);
        
        echo json_encode([
            "status" => "success",
            "message" => "Form submission processed and data payload validated successfully via API!",
            "processed_payload" => [
                "client_name" => $sanitized_name,
                "client_email" => $sanitized_email,
                "client_message" => $sanitized_message,
                "ingested_at" => date("Y-m-d H:i:s"),
                "token_id" => uniqid("msg_", true)
            ]
        ], JSON_PRETTY_PRINT);
    }
}

// -------------------------------------------------------------------------
// 3. INVALID METHOD ROUTING LAYER (Security Protocol Fallback)
// -------------------------------------------------------------------------
else {
    // Unsupported HTTP Protocol Action: Emitting 405 Method Not Allowed
    http_response_code(405);
    
    echo json_encode([
        "status" => "error",
        "error_type" => "PROTOCOL_MUTATION_DENIED",
        "message" => "HTTP Method '{$method}' is not allowed on this URI endpoint.",
        "allowed_methods" => ["GET", "POST"]
    ], JSON_PRETTY_PRINT);
}
?>