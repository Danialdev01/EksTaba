<?php
    header('Content-Type: application/json');

    // Get the raw POST data
    $data = json_decode(file_get_contents('php://input'), true);

    // Assuming you have a function to add points to a user
    if (isset($data['points'])) {
        $points = $data['points'];
        // Here you would typically update the score in your database
        // For example:
        // $userId = 1; // Get the user ID from session or request
        // updateUser Score($userId, $points);

        // Respond with success
        echo json_encode(['status' => 'success', 'points_added' => $points]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No points provided']);
    }
?>