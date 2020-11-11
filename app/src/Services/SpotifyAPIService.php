<?php
namespace Collageify\Services;


use SpotifyWebAPI\SpotifyWebAPI\Session as SpotifySession;

class SpotifyAPIService 
{
    public function __construct(CollageifyUser $user, String $time_span)
    {   
        $this->user = $user;
        $this->time_span = $time_span;
    }

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

    private function rankAlbumsByTracks(Array $tracks)
    {
        $albums = [];
        // For each track, with their ranking as key
        foreach($tracks as $ranking => $track) {
            // Get the album name
            $album_name = $track->album->name;

            // If the album isn't ranked already, add a count
            if (!isset($albums_count[$album_name])) {
                $albums[$album_name] = new CollageifyAlbum($album_name, $track->album, $ranking, 1);
            } else {
                // Otherwise, add a count to an existing album
                $albums[$album_name]->addCount();
            }
        }

        // Sort the array so that albums with the most counted tracks are first
        usort($albums, function($first_album, $second_album)
        {
            // If it's a tie, sort the highest ranked track
            if ($first_album->getCount() == $second_album->getCount())
            {
                return $first_album->getCollageRanking() > $second_album->getCollageRanking();
            }

            // Otherwise sort by the track count
            return $first_album->getCount() > $second_album->getCount();
        });

        return $albums;
    }
}