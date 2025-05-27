<?php
// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the raw POST data
    $json = file_get_contents('php://input');
    
    // Decode the JSON data
    $data = json_decode($json, true);
    
    // Access individual elements
    $startDate = $data['startDate'];
    $startTime = $data['startTime'];
    $endDate = $data['endDate'];
    $endTime = $data['endTime'];
    $imageName = $data['imageName'];
    $imagePath = $data['imagePath'];
    
    // Perform actions with the data (e.g., save to database, file handling, etc.)
    
    // Return a response
    echo "Received data: " . print_r($data, true);
}
?>
