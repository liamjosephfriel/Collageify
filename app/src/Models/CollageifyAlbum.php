<?php
namespace Collageify\Models;

class CollageifyAlbum 
{   
    private $name;
    private $api_album_data;
    private $collage_ranking;
    private $collage_count;

    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(String $name, Obj $api_album_data, Int $collage_ranking, Int $collage_count)
    {   
        $this->name = $name;
        $this->api_album_data = $api_album_data;
        $this->collage_ranking = $collage_ranking;
        $this->collage_count = $collage_count;
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
     * Get the value of collage_count
     */ 
    public function getCollageCount()
    {
        return $this->collage_count;
    }

    /**
     * Set the value of collage_count
     *
     * @return  self
     */ 
    public function setCollageCount($collage_count)
    {
        $this->collage_count = $collage_count;

        return $this;
    }
} 