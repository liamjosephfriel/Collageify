<?php
namespace Collageify\Services;

use SpotifyWebAPI\SpotifyWebAPI;
use SpotifyWebAPI\SpotifyWebAPI\Session as SpotifySession;


class SpotifyAuthService 
{
    public function __construct(CollageifyUser $user, String $time_span)
    {   
        $this->user = $user;
        $this->time_span = $time_span;
    }

    public function auth()
    {   
        
        if (!empty($_SESSION['spotify_auth']) && $this->isValidAuthString($_SESSION['spotify_auth']))
        {
            $api = new SpotifyWebAPI();
            $api->setAccessToken($_SESSION['spotify_auth']);
            return $api;
        }


        // User needs authed
        if (empty($_SESSION['spotify_auth']) && !empty($_GET['code'])) 
        {
           $this->requestToken();
        }

        if (!empty($_GET['code']) 
        {

        }
        
        if (!empty($_SESSION['spotify_auth'])) {
            $options = [
                'scope' => [
                    'user-read-recently-played',
                    'user-top-read'
                ],
            ];
    
            header('Location: ' . $session->getAuthorizeUrl($options));
            die();
        }
    }

    public function requestToken()
    {
        $session = new SpotifySession(
            $_ENV['SPOTIFY_CLIENT_ID'],
            $_ENV['SPOTIFY_CLIENT_SECRET'],
            $_ENV['SPOTIFY_REDIRECT_URL']
        );

        $options = [
            'scope' => [
                'user-read-recently-played',
                'user-top-read'
            ],
        ];


        $session->requestAccessToken($_GET['code']);
        $_SESSION['spotify_auth'] = $session->getAccessToken();

        $this->redirect('Location: ' . $session->getAuthorizeUrl($options));
    }


    public function redirect(String $string)
    {
        header('Location: ' . $string);
        exit();
    }
}