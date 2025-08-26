<?php
require_once 'config/session.php';
require_once 'classes/Contact.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $message = $_POST['message'] ?? '';
    $property_id = $_POST['property_id'] ?? null;
    
    if (!empty($name) && !empty($email) && !empty($message)) {
        $contact = new Contact();
        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'message' => $message,
            'property_id' => $property_id,
            'user_id' => getUserId()
        ];
        
        if ($contact->saveMessage($data)) {
            $response = ['success' => true, 'message' => 'Message sent successfully! We will contact you soon.'];
        } else {
            $response = ['success' => false, 'message' => 'Failed to send message. Please try again.'];
        }
    } else {
        $response = ['success' => false, 'message' => 'Please fill in all required fields.'];
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    header('Location: index.php');
}
exit();
?>