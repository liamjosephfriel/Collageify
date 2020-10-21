<?php
namespace Collageify\Services;

use Collageify\Models\CollageifyUser;
use Collageify\Models\CollageifyAlbum;

class CollageGenerationService 
{
    private $user;
    private $time_span;
    private $default_album_limit;

    public function __construct(CollageifyUser $user, String $time_span, Int $default_album_limit = 9)
    {   
        $this->user = $user;
        $this->time_span = $time_span;
        $this->default_album_limit = $default_album_limit;
    }

        
    /**
     * generateCollage
     * 
     * Entry point for ther
     *
     * @return void
     */
    public function generateCollage()
    {   
       $top_tracks = $this->getTopTracks();
       $collage_albums = $this->rankAlbumsByTracks($top_tracks);
       
       return $collage_albums;
    }

    private function getTopTracks() 
    {
        $options = [
            'time_range' => $this->time_span,
            'limit' => 50
        ];
        
        $top_tracks = $this->user->getTopTracks($options);
       
        return $top_tracks;
    }

    
    private function rankAlbumsByTracks(Array $tracks)
    {
        $albums = [];
        // For each track, with their ranking as key
        foreach($tracks as $ranking => $track) {
            // Use id to identify albums
            $album_id = $track->album->id;
            $album_name = $track->album->name;

            // If the album isn't ranked already, add a count
            if (!isset($albums[$album_id])) {
                $albums[$album_id] = new CollageifyAlbum($album_name, $track->album, $ranking, 1);
            } else {
                // Otherwise, add a count to an existing album
                $albums[$album_id]->incrementCount();
            }
        }
        
        // Sort the array so that albums with the most counted tracks are first
        usort($albums, function($first_album, $second_album)
        {
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