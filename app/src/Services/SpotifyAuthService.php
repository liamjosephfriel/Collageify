<?php
namespace Collageify\Services;

use SpotifyWebAPI\SpotifyWebAPI;
use SpotifyWebAPI\Session as SpotifySession;

class SpotifyAuthService 
{
    public function auth()
    {   
        // If the user is authed
        if (!empty($_SESSION['spotify_auth']))
        {
            $api = new SpotifyWebAPI();
            $api->setAccessToken($_SESSION['spotify_auth']);
            return $api;
        }

        // Otherwise, start session
        $session = new SpotifySession(
            $_ENV['SPOTIFY_CLIENT_ID'],
            $_ENV['SPOTIFY_CLIENT_SECRET'],
            $_ENV['SPOTIFY_REDIRECT_URL']
        );

        // User needs authed
        if (empty($_SESSION['spotify_auth']) && !empty($_GET['code'])) 
        {
           $this->setToken($session);
        }

        // User needs auth code
        $this->requestToken($session);
    }

    public function setToken(SpotifySession $session)
    {
        $session->requestAccessToken($_GET['code']);
        $_SESSION['spotify_auth'] = $session->getAccessToken();
        $this->redirect($_ENV['APP_URL']);
    }

    public function requestToken(SpotifySession $session)
    {
        $options = [
            'scope' => [
                'user-read-recently-played',
                'user-top-read'
            ],
        ];\

        header('Location: ' . $session->getAuthorizeUrl($options));
        die();
    }


    public function redirect(String $string)
    {
        header('Location: ' . $string);
        exit();
    }
}