<?php

    session_start();

    include '../config/connect.php';
    include '../backend/function/system.php';
    include '../backend/function/csrf-token.php';
    include '../backend/function/user.php';
    include '../backend/models/murid.php';

    checkCSRFToken();

    //@ Signup
    if(isset($_POST['signup'])){
        
        if(
            isset($_POST['email_murid']) &&
            isset($_POST['nama_murid']) && 
            isset($_POST['katalaluan_murid']) && 
            isset($_POST['pasti_katalaluan_murid'])
        ){

            // hasilkan murid
            $hasil = createMurid($_POST['nama_murid'], $_POST['email_murid'], $_POST['katalaluan_murid'], $_POST['pasti_katalaluan_murid'], $connect);
            
            validateFunction("../log/user_activity_log", "../", $hasil);

            $murid = json_decode($hasil, true);
            
            if($murid['status'] == "success"){
                
                // set session
                setUser($murid['id_murid'], $murid['katalaluan_murid'], "murid", $secret_key);

                // redirect murid
                log_activity_message("../log/user_activity_log", "Berjaya dafatar murid");
                alert_message("success", "Berjaya daftar pelajar");
                header("Location:../murid/");
            }

        }
        else{

            // data tidak lengkap
            log_activity_message("../log/user_activity_log", "Data tidak lengkap");
            alert_message("error", "Data tidak lengkap");
            header("Location:../");
        }
    }


    //@ Login
    else if(isset($_POST['login'])){

        if(
            isset($_POST['email_murid']) &&
            isset($_POST['katalaluan_murid'])
        ){
            
            // check login info 
            $hasil = checkMurid($_POST['email_murid'], $_POST['katalaluan_murid'], $connect);

            validateFunction("../log/user_activity_log", "../", $hasil);
            
            $murid = json_decode($hasil, true);
            
            if($murid['status'] == "success"){
                
                // set session
                setUser($murid['id_murid'], $murid['katalaluan_murid'], "murid", $secret_key);

                // redirect murid
                log_activity_message("../log/user_activity_log", "Berjaya log masuk murid");
                alert_message("success", "Berjaya daftar murid");
                header("Location:../murid/");
            }

        }
        else{

            // data tidak lengkap
            log_activity_message("../log/user_activity_log", "Data tidak lengkap");
            alert_message("error", "Data tidak lengkap");
            header("Location:../");
        }

    }

    //@ Signoup
    else if(isset($_POST['signout'])){

        if(isset($_POST['user_value_hash'])){

            session_destroy();
            setcookie('EksTabaUserHash', 2, time() - 3600 , "/");
            header("location:../");

        }
        else{

            // data tidak lengkap
            log_activity_message("../log/user_activity_log", "Data tidak lengkap");
            alert_message("error", "Data tidak lengkap");
            header("Location:../");

        }
    }

    //@ Pilih guru
    else if(isset($_POST['pilih_guru'])){
        
        $hasil = pilihGuru($_POST['id_murid'], $_POST['id_guru'], $connect);
            
        validateFunction("../log/user_activity_log", "../", $hasil);

        $murid = json_decode($hasil, true);
        
        if($murid['status'] == "success"){
            
            // redirect murid
            alert_message("success", "Berjaya kemaskini pelajar");
            header("Location:../murid/");
        }
        
    }
    else{

        // unknown function
        log_activity_message("../log/user_activity_log", "Unknown function");
        alert_message("error", "Unknown");
        header("Location:../");

    }
?>