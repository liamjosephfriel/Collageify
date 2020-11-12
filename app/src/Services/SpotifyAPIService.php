<?php
namespace Collageify\Services;

use SpotifyWebAPI\SpotifyWebAPI\Session as SpotifySession;

class SpotifyAPIService
{
    /**
     * Create instance of Spotify API
     *
     * @param  CollageifyUser $user
     * @param  string $time_span
     * @return void
     */
    public function __construct(CollageifyUser $user, String $time_span)
    {
        $this->user = $user;
        $this->time_span = $time_span;
    }

    /**
     * Register the Spotify API token
     *
     * @return void
     */
    public static function register()
    {
        $session = new SpotifySession(
            $_ENV['SPOTIFY_CLIENT_ID'],
            $_ENV['SPOTIFY_CLIENT_SECRET'],
            $_ENV['SPOTIFY_REDIRECT_URL']
        );

        $api = new SpotifyWebAPI\SpotifyWebAPI();

        if (isset($_GET['code'])) {
            $session->requestAccessToken($_GET['code']);
            $api->setAccessToken($session->getAccessToken());
        } else {
            $options = [
                'scope' => [
                    'user-read-email',
                ],
            ];

            header('Location: ' . $session->getAuthorizeUrl($options));
            die();
        }
    }
}
