<?php

    session_start();

    include '../config/connect.php';
    include '../backend/function/system.php';
    include '../backend/function/csrf-token.php';
    include '../backend/function/user.php';
    include '../backend/models/murid.php';
    require __DIR__ . "/../vendor/autoload.php";

    
    if(isset($_GET['code'])){

        echo "got code ". $GET['code'];
        // init google client
        $client = new Google\Client;
        $client->setClientId($clientId);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUri);

        // get access token
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

        echo "thing";
    
        // check if access token is available 
        if (!isset($token["access_token"])) {
            exit("Access token is not defined. Login Failed.");
        }
    
        // check access token
        $client->setAccessToken($token["access_token"]);
        $oauth = new Google\Service\Oauth2($client);
        $userinfo = $oauth->userinfo->get();
    
        // output user data

        if(isset($userinfo->email)){

            $check_user_sql = $connect->prepare("SELECT * FROM murid WHERE email_murid = ?");
            $check_user_sql->execute([$userinfo->email]);
            $check_user = $check_user_sql->fetch(PDO::FETCH_ASSOC);

            $email_murid = $userinfo->email;

            if($check_user['email_murid'] == $email_murid){
                
                // user dah pernah daftar
                
                $pwd_gsso = "pwd" . $userinfo->email;
                
                // set session user
                setUser($check_user['id_murid'], $pwd_gsso , "murid", $secret_key);
                
                log_activity_message("../log/user_activity_log", "Berjaya log masuk murid");
                alert_message("success", "Berjaya log masuk murid");
                header("Location:../murid/");
                
            }
            else{
                // user tak pernah daftar
                $pwd_gsso = "pwd" . $userinfo->email;
                
                // hasilkan user baru
                $hasil = createMurid($userinfo->givenName, $userinfo->email, $pwd_gsso, $pwd_gsso, $connect);
                
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

        }
        else{
            log_activity_message("../log/user_activity_log", "Data tidak lengkap");
            alert_message("error", "Data tidak lengkap");
            header("Location:../");
        }
    }
    else{
        log_activity_message("../log/user_activity_log", "Tidak berjaya log masuk");
        alert_message("error", "Tidak berjaya log masuk");
        header("Location:../");
    }


?>