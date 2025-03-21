<?php

    session_start();

    include '../config/connect.php';
    include '../backend/function/system.php';
    include '../backend/function/csrf-token.php';
    include '../backend/function/file.php';
    include '../backend/function/ai.php';
    include '../backend/models/nota.php';

    checkCSRFToken();

    //@ New Kuiz
    
    if(isset($_POST['new_nota'])){
        
        if(
            isset($_POST['id_kelas']) &&
            isset($_POST['id_guru']) &&
            isset($_POST['tajuk_nota']) &&
            isset($_POST['teks_nota'])  
            // isset($_POST['gambar_nota']) 
            // isset($_POST['audio_nota'])  
        ){
                
            $hasil = createNota($_POST['id_kelas'], $_POST['id_guru'], $_POST['tajuk_nota'], $_POST['teks_nota'], $connect);

            $nota = validateFunction("../log/user_activity_log", "../", $hasil);

            // if ada image tambah image
            if(isset($_POST['gambar_nota'])){
                addImageNota($nota['id_nota'], $_FILES['gambar_nota'], "../src/uploads/nota/gambar/", $connect);
            }

            // if ada audio tambah audio
            if(isset($_POST['audio_nota'])){
                addAudioNota($nota['id_nota'], $_FILES['audio_nota'], "../src/uploads/nota/gambar/", $connect);
            }

            if($nota['status'] == "success"){
                
                log_activity_message("../log/user_activity_log", "Berjaya Tambah Nota");
                alert_message("success", "Berjaya Tambah Nota");
                header("Location:../guru/nota/");

            }

        }
        else{

            log_activity_message("../log/user_activity_log", "Data tidak lengkap");
            alert_message("error", "Data tidak lengkap");
            header("Location: " . $_SERVER["HTTP_REFERER"]);   
        }

    }

    //@ Enter kuiz
    // else if(isset($_POST['enter_kuiz'])){

    //     if(
    //         isset($_POST['id_kuiz']) &&
    //         isset($_POST['id_murid'])
    //     ){
    //         $id_kuiz = validateInput($_POST['id_kuiz']);
    //         $id_murid = validateInput($_POST['id_murid']);
    //         $created_date_hasil_murid = date("Y-m-d");
            
    //         $markah_hasil_murid = [
    //             "bil_soalan_selesai" => 0,
    //             "markah_kuiz" => 0
    //         ];
    //         $markah_hasil_murid = json_encode($markah_hasil_murid);
            
    //         $hasil_kuiz_sql = $connect->prepare("INSERT INTO hasil_kuiz(id_hasil_kuiz, id_murid, id_kuiz, markah_hasil_murid, created_date_hasil_murid, status_hasil_murid) VALUES (NULL , ? , ? , ? , ? , 1)");
    //         $hasil_kuiz_sql = $hasil_kuiz_sql->execute([
    //             $id_murid,
    //             $id_kuiz,
    //             $markah_hasil_murid,
    //             $created_date_hasil_murid
    //         ]);

    //         $id_hasil = $connect->lastInsertId();
    //         log_activity_message("../log/user_activity_log", "Berjaya hasil laporan kuiz");
    //         alert_message("success", "Berjaya hasilkan kuiz");
    //         header("Location:../murid/kuiz/soalan.php?id_hasil=$id_hasil");   
    //     }
    // }
    else{
        log_activity_message("../log/user_activity_log", "Unknown function");
        alert_message("error", "Unknown");
        header("Location:../");
    }

?>