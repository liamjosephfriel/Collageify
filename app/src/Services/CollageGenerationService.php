<?php
namespace Collageify\Services;

use Collageify\Models\CollageifyAlbum;
use Collageify\Models\CollageifyUser;

class CollageGenerationService
{
    /**
     * The user that is generating the collage
     *
     * @var CollageifyUser
     */
    private $user;

    /**
     * The timespan value, can only be short_term, medium_term or long_term
     *
     * @var string
     */
    private $time_span;

    /**
     * The number of albums to show in the collage, default is 9
     *
     * @var integer
     */
    private $default_album_limit;

    /**
     * Create new collage generating instance
     *
     * @param  CollageifyUser $user
     * @param  string $time_span
     * @param  integer $default_album_limit
     * @return void
     */
    public function __construct(CollageifyUser $user, String $time_span, Int $default_album_limit = 9)
    {
        $this->user = $user;
        $this->time_span = $time_span;
        $this->default_album_limit = $default_album_limit;
    }

    /**
     * Entry point for the generation service
     *
     * @return void
     */
    public function generateCollage()
    {
        $top_tracks = $this->getTopTracks();
        $collage_albums = $this->rankAlbumsByTracks($top_tracks);

        return $collage_albums;
    }

    /**
     * Get the users top 50 tracks over a timespan
     *
     * @return array
     */
    private function getTopTracks()
    {
        $options = [
            'time_range' => $this->time_span,
            'limit' => 50,
        ];

        $top_tracks = $this->user->getTopTracks($options);

        return $top_tracks;
    }

    /**
     * Rank the albums for the collage
     * Count the number of album tracks in the top 50 tracks list, then rank them using the album count and position in the list
     *
     * @param  array $tracks
     * @return array
     */
    private function rankAlbumsByTracks(array $tracks)
    {
        $albums = [];
        // For each track, with their ranking as key
        foreach ($tracks as $ranking => $track) {
            // Use id to identify albums
            $album_name = $track->album->name;

            // Always get the first artist
            $artist_name = $track->artists[0]->name;

            // Full name of the album
            $album_full_title = $album_name . " - " . $artist_name;

            // If the album isn't ranked already, add a count
            if (!isset($albums[$album_full_title])) {
                $albums[$album_full_title] = new CollageifyAlbum($album_name, $track->album, $ranking, 1);
            } else {
                // Otherwise, add a count to an existing album
                $albums[$album_full_title]->incrementCount();
            }
        }

        // Sort the array so that albums with the most counted tracks are first
        usort($albums, function ($first_album, $second_album) {
            // If it's a tie, go by the album ranking
            if ($first_album->getCount() == $second_album->getCount()) {
                return $first_album->getCollageRanking() > $second_album->getCollageRanking();
            }

            return $second_album->getCount() > $first_album->getCount();
        });

        // Cut down the size of the collage
        $albums = array_slice($albums, 0, $this->default_album_limit);

        return $albums;
    }
}
