<?php
// filepath: c:\xampp\htdocs\new4\backend\enquiry-submit.php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');

require_once 'db.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Get POST data
        $full_name = isset($_POST['fullName']) ? sanitize_input($_POST['fullName']) : '';
        $email = isset($_POST['email']) ? sanitize_input($_POST['email']) : '';
        $mobile = isset($_POST['mobile']) ? sanitize_input($_POST['mobile']) : '';
        $subject = isset($_POST['subject']) ? sanitize_input($_POST['subject']) : '';
        $message = isset($_POST['message']) ? sanitize_input($_POST['message']) : '';
        $source = isset($_POST['source']) ? sanitize_input($_POST['source']) : 'website';
        
        // Get client info
        $ip_address = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        
        // Validation
        $errors = array();
        
        if (empty($full_name) || strlen($full_name) < 2) {
            $errors[] = "Full name must be at least 2 characters long";
        }
        
        if (empty($email)) {
            $errors[] = "Email is required";
        } elseif (!validate_email($email)) {
            $errors[] = "Invalid email format";
        }
        
        if (empty($mobile)) {
            $errors[] = "Mobile number is required";
        } elseif (!validate_mobile($mobile)) {
            $errors[] = "Invalid mobile number format (10-15 digits)";
        }
        
        if (empty($subject)) {
            $errors[] = "Please select an AI service";
        }
        
        // Check for spam (basic protection)
        if (strlen($message) > 1000) {
            $errors[] = "Message is too long (maximum 1000 characters)";
        }
        
        // Check for duplicate submission (same email within last hour)
        $duplicate_check = $conn->prepare("SELECT id FROM enquiries WHERE email = ? AND created_at > DATE_SUB(NOW(), INTERVAL 1 HOUR)");
        $duplicate_check->bind_param("s", $email);
        $duplicate_check->execute();
        $duplicate_result = $duplicate_check->get_result();
        
        if ($duplicate_result->num_rows > 0) {
            $errors[] = "You have already submitted an enquiry recently. Please wait before submitting again.";
        }
        $duplicate_check->close();
        
        if (!empty($errors)) {
            $response['success'] = false;
            $response['message'] = implode(", ", $errors);
        } else {
            // Prepare and execute insert statement
            $stmt = $conn->prepare("INSERT INTO enquiries (full_name, email, mobile, subject, message, ip_address, user_agent, source) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            
            if ($stmt) {
                $stmt->bind_param("ssssssss", $full_name, $email, $mobile, $subject, $message, $ip_address, $user_agent, $source);
                
                if ($stmt->execute()) {
                    $enquiry_id = $conn->insert_id;
                    
                    $response['success'] = true;
                    $response['message'] = "Thank you for your enquiry! We'll get back to you within 24 hours with your free consultation details.";
                    $response['enquiry_id'] = $enquiry_id;
                    
                    // Log successful submission
                    error_log("New enquiry submitted: ID $enquiry_id, Email: $email, Name: $full_name");
                    
                } else {
                    $response['success'] = false;
                    $response['message'] = "Error submitting enquiry. Please try again.";
                    error_log("Database error: " . $stmt->error);
                }
                
                $stmt->close();
            } else {
                $response['success'] = false;
                $response['message'] = "Database connection error. Please try again.";
                error_log("Database prepare error: " . $conn->error);
            }
        }
        
    } catch (Exception $e) {
        $response['success'] = false;
        $response['message'] = "An unexpected error occurred. Please try again.";
        error_log("Exception in enquiry-submit.php: " . $e->getMessage());
    }
    
} else {
    $response['success'] = false;
    $response['message'] = "Invalid request method";
}

// Close database connection
$conn->close();

echo json_encode($response);
?>