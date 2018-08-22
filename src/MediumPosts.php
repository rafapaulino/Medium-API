<?php
//https://github.com/Medium/medium-api-docs/blob/master/README.md#33-posts
namespace Medium;
use Medium\MediumRequest;

class MediumPosts extends MediumRequest
{
    private $_token;
    private $_userId;

    public function __construct($token, $userId)
    {
        parent::__construct();
        $this->_token = $token;
        $this->_userId = $userId;
    }

    public function add($title, $content, $tags = array(), $contentFormat = 'html'): array
    {
        $temp = $this->send(
            'https://api.medium.com/v1/users/' . $this->_userId . '/posts', 
            array(
                'title' => $title,
                'contentFormat' => $contentFormat,
                'content' => $content,
                'tags' => $tags,
                'publishStatus' => 'public'
            ),
            array(
                'Content-Type: application/json',
                'Accept: application/json',
                'Accept-Charset: utf-8',
                'Authorization: Bearer ' . $this->_token
            )
        );

        if (!is_array($temp)) {
            $result = array(
                'success' => false,
                'result' => $temp
            );
        } else {
            $result = $temp;
        }
        return $result;
    }
}