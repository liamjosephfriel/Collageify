<?php
namespace Collageify\Models;

use stdClass;

class CollageifyAlbum 
{   
    private $name;
    private $api_album_data;
    private $collage_ranking;
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
     * Increments the count attribute
     */
    public function incrementCount()
    {
        $this->count++;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of api_album_data
     */ 
    public function getApiAlbumData()
    {
        return $this->api_album_data;
    }

    /**
     * Set the value of api_album_data
     *
     * @return  self
     */ 
    public function setApiAlbumData($api_album_data)
    {
        $this->api_album_data = $api_album_data;

        return $this;
    }

    /**
     * Get the value of collage_ranking
     */ 
    public function getCollageRanking()
    {
        return $this->collage_ranking;
    }

    /**
     * Set the value of collage_ranking
     *
     * @return  self
     */ 
    public function setCollageRanking($collage_ranking)
    {
        $this->collage_ranking = $collage_ranking;

        return $this;
    }

    /**
     * Get the value of count
     */ 
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set the value of count
     *
     * @return  self
     */ 
    public function setCollageCount($count)
    {
        $this->count = $count;

        return $this;
    }
} 