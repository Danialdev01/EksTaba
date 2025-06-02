<?php

    session_start();

    include '../config/connect.php';
    include '../backend/function/system.php';
    include '../backend/function/csrf-token.php';
    include '../backend/models/soalan.php';

    checkCSRFToken();

    //@ New Kuiz
    
    if(isset($_POST['kemaskini_soalan'])){

        try{

            $id_soalan = validateInput($_POST['id_soalan']);
            $teks_soalan = validateInput($_POST['teks_soalan']);
            $markah_soalan = validateInput($_POST['markah_soalan']);
            $jawapan_betul = validateInput($_POST['jawapan_betul']);
    
    
            if($jawapan_betul == "?"){$teks_jawapan_json = '{"id_soalan":"'.$id_soalan.'","jawapan_betul":"?","jawapan_salah_1":".","jawapan_salah_2":",","jawapan_salah_3":"!"}';}
            elseif($jawapan_betul == "!"){$teks_jawapan_json = '{"id_soalan":"'.$id_soalan.'","jawapan_betul":"!","jawapan_salah_1":".","jawapan_salah_2":"?","jawapan_salah_3":","}';}
            elseif($jawapan_betul == "."){$teks_jawapan_json = '{"id_soalan":"'. $id_soalan .'","jawapan_betul":".","jawapan_salah_1":",","jawapan_salah_2":"?","jawapan_salah_3":"!"}';}
            else{$teks_jawapan_json = '{"id_soalan":"'. $id_soalan .'","jawapan_betul":",","jawapan_salah_1":".","jawapan_salah_2":"?","jawapan_salah_3":"!"}';}
    
            $kemaskini_jawapan_soalan_sql = $connect->prepare("UPDATE skema_jawapan SET teks_jawapan = :teks_jawapan WHERE id_soalan = :id_soalan");
            $kemaskini_jawapan_soalan_sql->execute([
                ":teks_jawapan" => $teks_jawapan_json,
                ":id_soalan" => $id_soalan
            ]);
    
            $kemaskini_soalan_sql = $connect->prepare("UPDATE soalan SET teks_soalan = :teks_soalan WHERE id_soalan = :id_soalan");
            $kemaskini_soalan_sql->execute([
                ":teks_soalan" => $teks_soalan,
                ":id_soalan" => $id_soalan
            ]);
            
            alert_message("success", "Berjaya kemaskini soalan");
            header("Location: " . $_SERVER["HTTP_REFERER"]);   
        }
        catch(Exception $e){
            alert_message("error", $e);
            header("Location: " . $_SERVER["HTTP_REFERER"]);   
        }
        
    }
    else{
        log_activity_message("../log/user_activity_log", "Unknown function");
        alert_message("error", "Unknown");
        header("Location:../");
    }

?>