<?php
namespace Collageify\Models;

use SpotifyWebAPI\SpotifyWebAPI;

class CollageifyUser 
{
    private $api;
    private $user_name;
    private $user_avatar_url;
    private $user_profile_url;

    /**
     * Create a new Collageify model instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(SpotifyWebAPI $api)
    {   
        $this->api = $api;
        $this->loadFromApi();        
    }
        
    /**
     * Loads from the API instance and only populates class with data that we require.
     *
     * @return void
     */
    private function loadFromApi()
    {
        // Request the users details from spotify
        $spotify_user = $this->api->me();
        // Only use what we need for privacy reasons
        $this->user_name = $spotify_user->display_name;
        $this->user_avatar_url = $spotify_user->images[0]->url;
        $this->user_profile_url = $spotify_user->external_urls->spotify;
    }
 
    /**
     * getTopTracks
     *
     * @param  mixed $options
     * @return Array
     */
    public function getTopTracks(Array $options = [])
    {   
        $top_tracks_query = $this->api->getMyTop('tracks', $options);
        $tracks = $top_tracks_query->items;

        return $tracks;
    }

    /**
     * getUserProfileUrl
     *
     * @return void
     */
    public function getUserProfileUrl()
    {
        return $this->user_profile_url;
    }

    /**
     * Get the value of user_name
     */ 
    public function getUserName()
    {
        return $this->user_name;
    }

    /**
     * Set the value of user_name
     *
     * @return  self
     */ 
    public function setUserName($user_name)
    {
        $this->user_name = $user_name;

        return $this;
    }

    /**
     * Get the value of user_avatar_url
     */ 
    public function getUserAvatarUrl()
    {
        return $this->user_avatar_url;
    }
}