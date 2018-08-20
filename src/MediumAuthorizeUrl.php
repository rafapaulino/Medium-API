<?php

namespace Medium;

class MediumAuthorizeUrl
{
    private $_url;

    public function __construct($client, $scope, $state, $redirect)
    {
        $this->_url = "https://medium.com/m/oauth/authorize?client_id={$client}&scope={$scope}&state={$state}&response_type=code&redirect_uri={$redirect}";
    }

    public function getUrl(): string 
    {
        return $this->_url;
    }
}