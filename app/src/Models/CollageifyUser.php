<?php
namespace Collageify\Models;

use SpotifyWebAPI\SpotifyWebAPI;

class CollageifyUser
{
    /**
     * Instance of the spotify web API, used to get user data
     *
     * @var SpotifyWebAPI
     */
    private $api;

    /**
     * The spotify username of this user
     *
     * @var mixed
     */
    private $user_name;

    /**
     * The spotify user avatar URL of this user
     *
     * @var mixed
     */
    private $user_avatar_url;

    /**
     * The spotify user profile URL for this user
     *
     * @var mixed
     */
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
     * Get the top tracks for this user from the API
     *
     * @param  mixed $options
     * @return array
     */
    public function getTopTracks(array $options = [])
    {
        $top_tracks_query = $this->api->getMyTop('tracks', $options);
        $tracks = $top_tracks_query->items;

        return $tracks;
    }

    /**
     * Get the users profile spotify URL
     *
     * @return string
     */
    public function getUserProfileUrl()
    {
        return $this->user_profile_url;
    }

    /**
     * Get the users spotify username
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->user_name;
    }

    /**
     * Set the users Spotify username
     *
     * @param  string $user_name
     * @return string
     */
    public function setUserName(String $user_name)
    {
        $this->user_name = $user_name;

        return $this;
    }

    /**
     * Get the users avatar URL on Spotify
     *
     * @return string
     */
    public function getUserAvatarUrl()
    {
        return $this->user_avatar_url;
    }
}
