<?php

function verifySessionGuru($secret_key, $connect){

    if(isset($_SESSION['EksTabaUserHash']) || isset($_COOKIE['EksTabaUserHash'])){
        
        if(!isset($_SESSION['EksTabaUserHash'])){
            
            $_SESSION['EksTabaUserHash'] = $_COOKIE['EksTabaUserHash'];
        }
        
        $user_value_hash = $_SESSION['EksTabaUserHash'];
        $user_value = decryptUser($user_value_hash, $secret_key);

        $id_user = validateInput($user_value['id_user']);
        $password_user = validateInput($user_value['password_user']);
        $type_user = validateInput($user_value['type']);


        if($type_user != "guru"){
            return encodeObj("403", "Jenis User Salah", "error");
            exit;
        }
        
        $user_sql = $connect->prepare("SELECT * FROM guru WHERE id_guru = ?");
        $user_sql->execute([$id_user]);
        $user = $user_sql->fetch(PDO::FETCH_ASSOC);
        
        if(password_verify($password_user, $user['katalaluan_guru'])){

            $status = encodeObj("200", "Berjaya log masuk guru", "success");
            
            $guru = [
                "id_guru" => $user['id_guru'],
                "email_guru" => $user['email_guru'],
                "nama_guru" => $user['nama_guru'],
                "katalaluan_guru" => $user_value['password_user']
            ];
            
            $guru = json_encode($guru);
            return addJson($status, $guru);
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
function createGuru($nama_guru, $email_guru, $katalaluan_guru, $pasti_katalaluan_guru, $connect){

    $email_guru = validateInput($email_guru);
    $nama_guru = validateInput($nama_guru);
    $created_date_guru = date("Y-m-d");
    $katalaluan_guru = validateInput($katalaluan_guru);
    $pasti_katalaluan_guru = validateInput($pasti_katalaluan_guru);

    // check if password is the same
    if(!($katalaluan_guru == $pasti_katalaluan_guru)){

        return encodeObj("400", "Katalaluan Tidak Sepadan", "error");
        exit;
    }

    // check if user is already in database
    $check_user_sql = $connect->prepare("SELECT * FROM guru WHERE nama_guru = ? AND email_guru = ?");
    $check_user_sql->execute([$nama_guru,$email_guru]);
    if($check_user_sql->fetch(PDO::FETCH_ASSOC)){

        return encodeObj("401", "Nama atau Email telah berdaftar", "error");
        exit;
    }

    try{

        // masukkan murid dalam database
        $katalaluan_guru_hashed = password_hash($katalaluan_guru, PASSWORD_DEFAULT);
        $create_user_sql = $connect->prepare("INSERT INTO guru(id_guru, email_guru, nama_guru, katalaluan_guru, created_date_guru, status_guru) VALUES (NULL, ? , ? , ? , ? , 1)");
        $create_user_sql->execute([
            $email_guru,
            $nama_guru,
            $katalaluan_guru_hashed,
            $created_date_guru
        ]);

        $id_guru = $connect->lastInsertId();

        $status = encodeObj("200", "Berjaya daftar guru", "success");
        $guru = [

            "id_guru" => $id_guru,
            "email_guru" => $email_guru,
            "nama_guru" => $nama_guru,
            "katalaluan_guru" => $katalaluan_guru
        ];

        $guru = json_encode($guru);
        return addJson($status, $guru);

    }
    catch(PDOException $e){
        return $e;
        exit;
    }

}

function checkGuru($email_guru, $katalaluan_guru, $connect){
    
    $email_guru = validateInput($email_guru);
    $katalaluan_guru = validateInput($katalaluan_guru);

    // check user dalam database
    $check_user_sql = $connect->prepare("SELECT * FROM guru WHERE email_guru = ?");
    $check_user_sql->execute([$email_guru]);
    $check_user = $check_user_sql->fetch(PDO::FETCH_ASSOC);

    // check email

    if(($check_user['email_guru'] != $email_guru)){

        return encodeObj("401", "Email tidak berdaftar", "error");
        exit;
    }

    // check password
    else if(!(password_verify($katalaluan_guru, $check_user['katalaluan_guru']))){

        return encodeObj("402", "Katalaluan tidak sepadan", "error");
        exit;
    }

    else{

        $status = encodeObj("200", "Berjaya log masuk guru", "success");
        
        $guru = [
            "id_guru" => $check_user['id_guru'],
            "email_guru" => $email_guru,
            "nama_guru" => $check_user['nama_guru'],
            "katalaluan_guru" => $katalaluan_guru
        ];
        
        $guru = json_encode($guru);
        return addJson($status, $guru);
    }
    
}
?>