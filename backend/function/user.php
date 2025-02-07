<?php

    //@ Encrypt
    function encryptUser($id_user, $password_user, $secret_key){

        $user_value_txt = "id_user=$id_user&password_user=$password_user";
        $user_value_hash = openssl_encrypt($user_value_txt, 'AES-256-CBC', $secret_key, 0, 'v_for_encryption');
        return $user_value_hash;
    }

    //@ Decrypt
    function decryptUser($user_value_hash, $secret_key){

        $user_value_txt = openssl_decrypt($user_value_hash, 'AES-256-CBC', $secret_key, 0, 'v_for_encryption');
        parse_str($user_value_txt, $user_value);
        return $user_value;
    }

    //@ Validate 
    function validateUser($user_value_hash, $id_user, $password_user, $secret_key){

        $user_value = decryptUser($user_value_hash, $secret_key);

        if(!($user_value['id_user'] == $id_user)){
            
            // if id user is wrong
            return false;
            exit;
        }

        if(!($user_value['password_user'] == $password_user)){
            
            // if id user is wrong
            return false;
            exit;
        }

        return true;
    }

    
    //@ Set Session User
    function setUser($id_user, $password_user, $secret_key){

        $user_value_hash = encryptUser($id_user, $password_user, $secret_key);

        setcookie("MyCookingInventoryUserHash", $user_value_hash, time() + (86400 * 30), "/");
        $_SESSION['MyCookingInventoryUserHash'] = $user_value_hash;


    }

    //@ Verify session user
    function verifySessionUser($secret_key, $connect){

        if(isset($_SESSION['MyCookingInventoryUserHash']) || isset($_COOKIE['MyCookingInventoryUserHash'])){
            
            if(!isset($_SESSION['MyCookingInventoryUserHash'])){
                
                $_SESSION['MyCookingInventoryUserHash'] = $_COOKIE['MyCookingInventoryUserHash'];
            }

            
            $user_value_hash = $_SESSION['MyCookingInventoryUserHash'];
            $user_value = decryptUser($user_value_hash, $secret_key);
            
            $id_user = validateInput($user_value['id_user']);
            $password_user = validateInput($user_value['password_user']);

            $user_sql = $connect->prepare("SELECT * FROM users WHERE id_user = ?");
            $user_sql->execute([$id_user]);
            $user = $user_sql->fetch(PDO::FETCH_ASSOC);

            if(password_verify($password_user, $user['password_user'])){

                return "SUCCESS";
            }
            else{

                return "Password Session Wrong";
            }
        }
        else{

            return "Session Is Not Set";
        }
    }

    //@ Create User
    function createUser($name_user, $email_user, $password_user, $password_confirm_user, $connect){

        $name_user = validateInput($name_user);
        $email_user = validateInput($email_user);
        $create_date_user = date("Y-m-d");
        $password_user = validateInput($password_user);
        $password_confirm_user = validateInput($password_confirm_user);

        // check if password is the same
        if(!($password_user == $password_confirm_user)){
            return "Wrong Confirm Password";
            exit;
        }

        // check if user is already in database
        $check_user_sql = $connect->prepare("SELECT * FROM users WHERE name_user = ? AND email_user = ?");
        $check_user_sql->execute([$name_user,$email_user]);
        $check_user = $check_user_sql->fetch(PDO::FETCH_ASSOC);
        if($check_user){
            return "User Already Signed Up";
            exit;
        }

        try{

            $password_user_hashed = password_hash($password_user, PASSWORD_DEFAULT);
            $create_user_sql = $connect->prepare("INSERT INTO users(id_user, name_user, email_user, password_user, create_date_user, status_user) VALUES (NULL, ? , ? , ? , ? , 1)");
            $create_user_sql->execute([
                $name_user,
                $email_user,
                $password_user_hashed,
                $create_date_user
            ]);

            return "SUCCESS";

        }
        catch(PDOException $e){
           return $e;
           exit;
        }

    }

?>