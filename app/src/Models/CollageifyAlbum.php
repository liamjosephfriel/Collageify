<?php
namespace Collageify\Models;

use stdClass;

class CollageifyAlbum
{
    /**
     * The name of the album, from Spotify
     *
     * @var string
     */
    private $name;

    /**
     * The API album data from Spotify
     *
     * @var mixed
     */
    private $api_album_data;

    /**
     * The ranking of the album, which is the position of the first track in the most played tracks list
     *
     * @var integer
     */
    private $collage_ranking;

    /**
     * The number of tracks this album has in most played track list
     *
     * @var integer
     */
    private $count;

    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(String $name, stdClass $api_album_data, Int $collage_ranking, Int $count)
    {
        $this->name = $name;
        $this->api_album_data = $api_album_data;
        $this->collage_ranking = $collage_ranking;
        $this->count = $count;
    }

    /**
     * Increments the count of the number of tracks for this album featured in the most played tracks
     *
     * @return void
     */
    public function incrementCount()
    {
        $this->count++;
    }

    /**
     * Get the name of the album
     *
     * @return void
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the album name
     *
     * @param  mixed $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get the API data for this album
     *
     * @return void
     */
    public function getApiAlbumData()
    {
        return $this->api_album_data;
    }

    /**
     * Set the API gathered album data
     *
     * @param  mixed $api_album_data
     * @return void
     */
    public function setApiAlbumData($api_album_data)
    {
        $this->api_album_data = $api_album_data;
    }

    /**
     * Get the ranking of this album in the collage
     *
     * @return void
     */
    public function getCollageRanking()
    {
        return $this->collage_ranking;
    }

    /**
     * Set the collage ranking of this album
     *
     * @param  mixed $collage_ranking
     * @return void
     */
    public function setCollageRanking($collage_ranking)
    {
        $this->collage_ranking = $collage_ranking;
    }

    /**
     * Get the count of the number of top tracks in this album
     *
     * @return void
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set the track count value
     *
     * @param  mixed $count
     * @return void
     */
    public function setCollageCount($count)
    {
        $this->count = $count;
    }
}
