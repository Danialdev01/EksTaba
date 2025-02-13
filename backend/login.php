<?php

    session_start();

    include '../config/connect.php';

    require __DIR__ . "/../vendor/autoload.php";

    $client = new Google\Client;

    $client->setClientId($clientId);
    $client->setClientSecret($clientSecret);
    $client->setRedirectUri($redirectUri);

    // check if code is valid  
    if(!isset($_GET['code'])){
        exit("Login Failed");
    }

    // get access token
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    // check if access token is available 
    if (!isset($token["access_token"])) {
        exit("Access token is not defined. Login Failed.");
    }

    // check access token
    $client->setAccessToken($token["access_token"]);
    $oauth = new Google\Service\Oauth2($client);
    $userinfo = $oauth->userinfo->get();

    // output user data
    var_dump(
        $userinfo->email,
        $userinfo->familyName,
        $userinfo->gender
    );

?>