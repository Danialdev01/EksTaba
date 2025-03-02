<?php

    session_start();

    include '../config/connect.php';
    include '../backend/function/system.php';
    include '../backend/function/csrf-token.php';
    include '../backend/function/user.php';
    include '../backend/models/guru.php';
    include '../backend/models/kelas.php';

    checkCSRFToken();

    //@ Signup
    if(isset($_POST['signup'])){
        
        if(
            isset($_POST['email_guru']) &&
            isset($_POST['nama_guru']) && 
            isset($_POST['katalaluan_guru']) && 
            isset($_POST['pasti_katalaluan_guru'])
        ){

            // hasilkan murid
            $hasil = createGuru($_POST['nama_guru'], $_POST['email_guru'], $_POST['katalaluan_guru'], $_POST['pasti_katalaluan_guru'], $connect);
            
            validateFunction("../log/user_activity_log", "../", $hasil);

            $guru = json_decode($hasil, true);
            
            if($murid['status'] == "success"){
                
                // set session
                setUser($guru['id_guru'], $guru['katalaluan_guru'], "guru", $secret_key);

                // redirect murid
                log_activity_message("../log/user_activity_log", "Berjaya dafatar guru");
                alert_message("success", "Berjaya daftar guru");
                header("Location: " . $_SERVER["HTTP_REFERER"]);   
            }

        }
        else{

            // data tidak lengkap
            log_activity_message("../log/user_activity_log", "Data tidak lengkap");
            alert_message("error", "Data tidak lengkap");
            header("Location: " . $_SERVER["HTTP_REFERER"]);   
        }
    }

    //@ Login
    else if(isset($_POST['login'])){

        if(
            isset($_POST['email_guru']) &&
            isset($_POST['katalaluan_guru'])
        ){
            
            // check login info 
            $hasil = checkGuru($_POST['email_guru'], $_POST['katalaluan_guru'], $connect);

            validateFunction("../log/user_activity_log", "../", $hasil);
            $guru = json_decode($hasil, true);
            
            
            if($guru['status'] == "success"){
                
                // set session
                setUser($guru['id_guru'], $guru['katalaluan_guru'], "guru", $secret_key);

                // redirect murid
                log_activity_message("../log/user_activity_log", "Berjaya log masuk");
                alert_message("success", "Berjaya log masuk");
                header("Location:../guru/");
            }

        }
        else{

            // data tidak lengkap
            log_activity_message("../log/user_activity_log", "Data tidak lengkap");
            alert_message("error", "Data tidak lengkap");
            header("Location:../");
        }

    }

    //@ Sign out

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

    //@ Kelas 
    //* new kelas
    else if(isset($_POST['new_kelas'])){

        if(
            isset($_POST['id_guru']) &&
            isset($_POST['tajuk_kelas']) &&
            isset($_POST['info_kelas'])
        ){

            echo "thing";
            $hasil = createKelas($_POST['id_guru'], $_POST['tajuk_kelas'], $_POST['info_kelas'], $connect);

            validateFunction("../log/user_activity_log", "../", $hasil);

            $kelas = json_decode($hasil, true);
            
            if($kelas['status'] == "success"){

                log_activity_message("../log/user_activity_log", "Berjaya log masuk");
                alert_message("success", "Berjaya log masuk");
                header("Location:../guru/kelas/");

            }

        }
        else{

            log_activity_message("../log/user_activity_log", "Data tidak lengkap");
            alert_message("error", "Data tidak lengkap");
            header("Location:../");
        }
    }

    //@ Error Unknown
    else{

        // unknown function
        log_activity_message("../log/user_activity_log", "Unknown function");
        alert_message("error", "Unknown");
        header("Location:../");

    }
?>