<?php
include 'vendor/autoload.php';

use Medium\MediumStateManager;
use Medium\MediumAuthorizeUrl;
use Medium\MediumAuth;

$client_id = '614518c4592a';
$secret = '3d8a15d7b0e73d278d18833380a7583cacc7ab43';
$scope = 'basicProfile,publishPost,listPublications';
$redirect_url = 'http://rafathemes.com.br/medium/';

$session = new MediumStateManager;

$code = isset($_REQUEST["code"]) ? $_REQUEST["code"] : '';

if( empty($code) ) {

    $session->setState();
    $state = $session->getState();

    $wp = new MediumAuthorizeUrl(
        $client_id,
        $scope,
        $state,
        $redirect_url
    );
    $url = $wp->getUrl();

    echo '<a href="' . $url .'">Login</a>';

 } elseif ( $session->verifyStateIsValid() ) {

    $auth = new MediumAuth(
        $code, 
        $client_id,
        $secret, 
        $redirect_url
    );

    $token = $auth->getToken();

    echo '<pre>';
    var_dump($token);
    echo '</pre>';

 }
