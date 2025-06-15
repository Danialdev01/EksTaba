<?php

function verifySessionMurid($secret_key, $connect){

    if(isset($_SESSION['EksTabaUserHash']) || isset($_COOKIE['EksTabaUserHash'])){
        
        if(!isset($_SESSION['EksTabaUserHash'])){
            
            $_SESSION['EksTabaUserHash'] = $_COOKIE['EksTabaUserHash'];
        }

        $user_value_hash = $_SESSION['EksTabaUserHash'];
        $user_value = decryptUser($user_value_hash, $secret_key);

        
        $id_user = validateInput($user_value['id_user']);
        $password_user = validateInput($user_value['password_user']);
        $type_user = validateInput($user_value['type']);

        if($type_user != "murid"){
            return encodeObj("400", "Katalaluan tidak sepadan", "error");
            exit;
        }
        
        $user_sql = $connect->prepare("SELECT * FROM murid WHERE id_murid = ?");
        $user_sql->execute([$id_user]);
        $user = $user_sql->fetch(PDO::FETCH_ASSOC);
        
        if(password_verify($password_user, $user['katalaluan_murid'])){

            $status = encodeObj("200", "Berjaya log masuk murid", "success");
            
            $murid = [
                "id_murid" => $user['id_murid'],
                "email_murid" => $user['email_murid'],
                "nama_murid" => $user['nama_murid'],
                "katalaluan_murid" => $user_value['password_user']
            ];
            
            $murid = json_encode($murid);
            return addJson($status, $murid);
        }
        else{
            
            return encodeObj("400", "Katalaluan tidak sepadan", "error");
        }
    }
    else{

        return encodeObj("400", "Pengguna belum Log Masuk", "error");
    }
}

//@ create
function createMurid($nama_murid, $email_murid, $katalaluan_murid, $pasti_katalaluan_murid, $connect){

    $email_murid = validateInput($email_murid);
    $nama_murid = validateInput($nama_murid);
    $created_date_murid = date("Y-m-d");
    $katalaluan_murid = validateInput($katalaluan_murid);
    $pasti_katalaluan_murid = validateInput($pasti_katalaluan_murid);

    // check if password is the same
    if(!($katalaluan_murid == $pasti_katalaluan_murid)){

        return encodeObj("400", "Katalaluan Tidak Sepadan", "error");
        exit;
    }

    // check if user is already in database
    $check_user_sql = $connect->prepare("SELECT * FROM murid WHERE nama_murid = ? AND email_murid = ?");
    $check_user_sql->execute([$nama_murid,$email_murid]);
    if($check_user_sql->fetch(PDO::FETCH_ASSOC)){

        return encodeObj("401", "Nama atau Email telah berdaftar", "error");
        exit;
    }

    try{

        // masukkan murid dalam database
        $katalaluan_murid_hashed = password_hash($katalaluan_murid, PASSWORD_DEFAULT);
        $create_user_sql = $connect->prepare("INSERT INTO murid(id_murid, email_murid, nama_murid, katalaluan_murid, info_murid, markah_murid, created_date_murid, status_murid) VALUES (NULL, ? , ? , ? , NULL , 0 , ? , 1)");
        $create_user_sql->execute([
            $email_murid,
            $nama_murid,
            $katalaluan_murid_hashed,
            $created_date_murid
        ]);

        $id_murid = $connect->lastInsertId();

        $status = encodeObj("200", "Berjaya daftar murid", "success");
        $murid = [

            "id_murid" => $id_murid,
            "email_murid" => $email_murid,
            "nama_murid" => $nama_murid,
            "katalaluan_murid" => $katalaluan_murid
        ];

        $murid = json_encode($murid);
        return addJson($status, $murid);

    }
    catch(PDOException $e){
        return encodeObj("400", "$e", "error");
        exit;
    }

}

function pilihGuru($id_murid, $id_guru, $connect){

    try{

        $id_murid = validateInput($id_murid);
        $id_guru = validateInput($id_guru);

        $check_guru_murid_sql = $connect->prepare("SELECT info_murid FROM murid WHERE id_murid = :id_murid");
        $check_guru_murid_sql->execute([
            ":id_murid" => $id_murid
        ]);
        $check_guru_murid = $check_guru_murid_sql->fetchColumn();

        if($check_guru_murid == NULL || trim($check_guru_murid) === ''){

            $info_murid = [
                "id_guru" => $id_guru,
            ];
            
            $info_murid = json_encode($info_murid);

            $update_info_murid_sql = $connect->prepare("UPDATE murid SET info_murid = :info_murid WHERE id_murid = :id_murid");
            $update_info_murid_sql->execute([
                ":info_murid" => $info_murid,
                ":id_murid" => $id_murid
            ]);

            $status = encodeObj("200", "Berjaya kemaskini murid", "success");
            $murid = [
                "id_murid" => $id_murid,
                "id_guru" => $id_guru,
            ];

            $murid = json_encode($murid);
            return addJson($status, $murid);
        }

    }
    catch(Exception $e){
        return encodeObj("400", "$e", "error");

    }

}

function checkMurid($email_murid, $katalaluan_murid, $connect){
    
    $email_murid = validateInput($email_murid);
    $katalaluan_murid = validateInput($katalaluan_murid);

    // check user dalam database
    $check_user_sql = $connect->prepare("SELECT * FROM murid WHERE email_murid = ?");
    $check_user_sql->execute([$email_murid]);
    $check_user = $check_user_sql->fetch(PDO::FETCH_ASSOC);

    // check email

    if(($check_user['email_murid'] != $email_murid)){

        return encodeObj("401", "Email tidak berdaftar", "error");
        exit;
    }

    // check password
    else if(!(password_verify($katalaluan_murid, $check_user['katalaluan_murid']))){

        return encodeObj("402", "Katalaluan tidak sepadan", "error");
        exit;
    }

    else{

        $status = encodeObj("200", "Berjaya log masuk murid", "success");
        
        $murid = [
            "id_murid" => $check_user['id_murid'],
            "email_murid" => $email_murid,
            "nama_murid" => $check_user['nama_murid'],
            "katalaluan_murid" => $katalaluan_murid
        ];
        
        $murid = json_encode($murid);
        return addJson($status, $murid);
    }
    
    
}
?>