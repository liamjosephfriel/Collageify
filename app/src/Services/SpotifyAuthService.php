<?php
namespace Collageify\Services;

use Collageify\Util\CollageifyUtil;
use SpotifyWebAPI\Session as SpotifySession;
use SpotifyWebAPI\SpotifyWebAPI;

class SpotifyAuthService
{
    /**
     * Auth the application using the Spotify API
     *
     * @return mixed
     */
    public function auth()
    {
        // If the user is authed
        if (!empty($_SESSION['spotify_auth'])) {
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
        if (empty($_SESSION['spotify_auth']) && !empty($_GET['code'])) {
            $this->setToken($session);
        }

        if (!empty($_GET['auth']) && $_GET['auth']) {
            // User needs auth code
            $this->requestToken($session);
            echo 'test';
        }

        return null;
    }

    /**
     * Set the Spotify API token
     *
     * @param  SpotifySession $session
     * @return void
     */
    public function setToken(SpotifySession $session)
    {
        $session->requestAccessToken($_GET['code']);
        $_SESSION['spotify_auth'] = $session->getAccessToken();
        CollageifyUtil::redirect($_ENV['APP_URL']);
    }

    /**
     * De-auth, end session
     *
     * @return void
     */
    public static function logout()
    {
        unset($_SESSION['spotify_auth']);
        CollageifyUtil::redirect($_ENV['APP_URL']);
    }

    /**
     * Request token from Spotify API using the following permissions
     *
     * @param  SpotifySession $session
     * @return void
     */
    public function requestToken(SpotifySession $session)
    {
        $options = [
            'scope' => [
                'user-read-recently-played',
                'user-top-read',
            ],
        ];

        CollageifyUtil::redirect($session->getAuthorizeUrl($options));
    }
}
