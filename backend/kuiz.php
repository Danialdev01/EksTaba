<?php

    session_start();

    include '../config/connect.php';
    include '../backend/function/system.php';
    include '../backend/function/csrf-token.php';
    include '../backend/function/ai.php';
    include '../backend/models/kuiz.php';
    include '../backend/models/soalan.php';

    checkCSRFToken();

    //@ New Kuiz
    
    if(isset($_POST['new_kuiz'])){
        
        if(
            isset($_POST['nama_kuiz']) &&
            isset($_POST['pengenalan_kuiz']) &&
            isset($_POST['jenis_kuiz']) && 
            isset($_POST['id_kelas']) && 
            isset($_POST['id_guru']) && 
            isset($_POST['tarikh_tamat_kuiz']) && 
            isset($_POST['bil_soalan_kuiz'])
        ){
                
            $hasil = createKuiz($_POST['nama_kuiz'], $_POST['pengenalan_kuiz'], $_POST['jenis_kuiz'], $_POST['id_kelas'], $_POST['id_guru'], $_POST['tarikh_tamat_kuiz'], $connect);

            $kuiz = validateFunction("../log/user_activity_log", "../", $hasil);

            
            if($kuiz['status'] == "success"){
                
                for($i = 0;$_POST['bil_soalan_kuiz'] > $i; $i++){

                    if($kuiz['jenis_kuiz'] == "1"){

                        $output = SoalanObjectiveAI($kuiz['id_kuiz'], $ai_api_key, $kuiz['pengenalan_kuiz'], $connect);
                    }

                }

                $id_kuiz = $kuiz['id_kuiz'];
                log_activity_message("../log/user_activity_log", "Berjaya hasilkan kuiz");
                alert_message("success", "Berjaya hasilkan kuiz");
                header("Location:../guru/kuiz/lihat-kuiz.php?id_kuiz=$id_kuiz");

            }

        }
        else{

            log_activity_message("../log/user_activity_log", "Data tidak lengkap");
            alert_message("error", "Data tidak lengkap");
            header("Location: " . $_SERVER["HTTP_REFERER"]);   
        }

    }

    //@ Enter kuiz
    else if(isset($_POST['enter_kuiz'])){

        if(
            isset($_POST['id_kuiz']) &&
            isset($_POST['id_murid'])
        ){
            $id_kuiz = validateInput($_POST['id_kuiz']);
            $id_murid = validateInput($_POST['id_murid']);
            $created_date_hasil_murid = date("Y-m-d");
            
            $markah_hasil_murid = [
                "bil_soalan_selesai" => 0,
                "markah_kuiz" => 0
            ];
            $markah_hasil_murid = json_encode($markah_hasil_murid);
            
            $hasil_kuiz_sql = $connect->prepare("INSERT INTO hasil_kuiz(id_hasil_kuiz, id_murid, id_kuiz, markah_hasil_murid, created_date_hasil_murid, status_hasil_murid) VALUES (NULL , ? , ? , ? , ? , 1)");
            $hasil_kuiz_sql = $hasil_kuiz_sql->execute([
                $id_murid,
                $id_kuiz,
                $markah_hasil_murid,
                $created_date_hasil_murid
            ]);

            $id_hasil = $connect->lastInsertId();
            log_activity_message("../log/user_activity_log", "Berjaya hasil laporan kuiz");
            alert_message("success", "Berjaya hasilkan kuiz");
            header("Location:../murid/kuiz/soalan.php?id_hasil=$id_hasil");   
        }
    }
    else{
        log_activity_message("../log/user_activity_log", "Unknown function");
        alert_message("error", "Unknown");
        header("Location:../");
    }

?>