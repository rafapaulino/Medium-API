<?php
include 'vendor/autoload.php';

use Medium\MediumStateManager;
use Medium\MediumAuthorizeUrl;
use Medium\MediumAuth;
use Medium\MediumMe;
use Medium\MediumPosts;

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

    echo '<h4>Token:</h4><pre>';
    var_dump($token);
    echo '</pre><hr>';

    $refresh = $auth->refreshToken($token["refresh_token"]);

    echo '<h4>Refresh Token:</h4><pre>';
    var_dump($refresh);
    echo '</pre><hr>';

    $me = new MediumMe($token["access_token"]);
    $user = $me->getUser();

    echo '<h4>Dados do usuário:</h4><pre>';
    var_dump($user);
    echo '</pre><hr>';

    $posts = new MediumPosts($token["access_token"], $user['data']['id']);
    $artigo = $posts->add(
        'Testando a api do Medium',
        '<h1>Testando a api do medium</h1><p>Isso é muito legal <a href="http://www.uol.com.br">Clique aqui</a>',
        array(
            'Teste', 'api', 'medium'
        )
    );

    echo '<h4>Dados do post adicionado:</h4><pre>';
    var_dump($artigo);
    echo '</pre><hr>';

 }
