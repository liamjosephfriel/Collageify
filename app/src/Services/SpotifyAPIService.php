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

            print_r($api->me());
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

    private function getHighestRankedAlbums(Array $albums, Int $number_of_albums = self::DEFAULT_ALBUM_LIMIT)
    {
        // Final array of albums
        $collage_albums = [];

        // On the first pass, only get albums that have more than 1 track listed
        foreach($collage_albums as $album) {
            if ($album->getCount() > 1) {
                $album_rankings[$album_name] = $album;
            } else {
                break;
            }
        }

        
        // If the number of albums that we've got is lower than the limit
        $missing_album_count = count($album_rankings) - self::DEFAULT_ALBUM_LIMIT;

        if ($missing_album_count > 0) {
            // Go through the albums that are 
            foreach($album_rankings as $album_name => $album) {

                if ($missing_album_count < 1) { 
                    break;
                }

                $album_rankings[$album_name] = 1;

                $missing_album_count -= 1;
            }
        }

        return $album_rankings;
    }

    private function getMissingTracks(Array $track_list)
    {

    }
}