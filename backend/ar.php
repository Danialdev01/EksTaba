<?php

    include '../config/connect.php';
    include '../backend/function/system.php';

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
    }
    
    else if(isset($_POST['new_markah'])){

        $new_markah_sql = $connect->prepare("INSERT INTO ar(id_ar, nama_murid , hasil_murid, markah1, markah2, markah3, markah4, tarikh_ar, status_ar) VALUES (NULL , :nama_murid, :hasil_murid, :markah1, :markah2, :markah3, :markah4, :tarikh_ar, 1)");
        $new_markah_sql->execute([
            ":nama_murid" => $_POST['nama_murid'],
            ":hasil_murid" => $_POST['markah1'] + $_POST['markah2'] + $_POST['markah3'] + $_POST['markah4'],
            ":markah1" => $_POST['markah1'],
            ":markah2" => $_POST['markah2'],
            ":markah3" => $_POST['markah3'],
            ":markah4" => $_POST['markah4'],
            ":tarikh_ar" => date("Y-m-d")
        ]);

        alert_message("success", "Berjaya hantar markah");
        header("Location:../");   
    }
    else {
        echo json_encode(['status' => 'error', 'message' => 'No points provided']);
    }
?>