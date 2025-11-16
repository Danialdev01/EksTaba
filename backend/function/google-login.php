<?php

    require __DIR__ . "/../../vendor/autoload.php";
    
    function generateGoogleUrl($clientId, $clientSecret, $redirectUri){

        try{

            $client = new Google\Client;
        
            $client->setClientId($clientId);
            $client->setClientSecret($clientSecret);
            $client->setRedirectUri($redirectUri);
            
            $client->addScope("email");
            $client->addScope("profile");
    
            $client->addScope("email");
            $client->addScope("profile");

            return $client->createAuthUrl();
        }

        catch (Exception $e) {
            exit("Error loading Google SDK: " . $e->getMessage());
        }   
        
    }

    function getGoogleUserInfo($code, $clientId, $clientSecret, $redirectUri){

        $client = new Google\Client;

        $client->setClientId($clientId);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUri);

        // check if code is valid  
        if(!isset($code)){
            exit("Login Failed");
        }

        // get access token
        $token = $client->fetchAccessTokenWithAuthCode($code);

        // check if access token is available 
        if (!isset($token["access_token"])) {
            exit("Access token is not defined. Login Failed.");
        }

        // check access token
        $client->setAccessToken($token["access_token"]);
        $oauth = new Google\Service\Oauth2($client);
        return $oauth->userinfo->get();

    }

?>