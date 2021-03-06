<?php
namespace Collageify\Services;

use Collageify\Models\CollageifyUser;
use Collageify\Services\CollageifyValidationService;
use SpotifyWebAPI\SpotifyWebAPIException;
use Twig_Environment;

class CollageifyAppService
{
    /**
     * The authed Spotify API
     *
     * @var SpotifyWebAPI
     */
    private $authed_api;

    /**
     * Twig instance
     *
     * @var Twig_Environment
     */
    private $twig;

    /**
     * Create instance of the app service
     *
     * @param  mixed $authed_api
     * @param  Twig_Environment $twig
     * @return void
     */
    public function __construct($authed_api, Twig_Environment $twig)
    {
        $this->authed_api = $authed_api;
        $this->twig = $twig;
    }

    /**
     * Application entrypoint/run function
     *
     * @return void
     */
    public function run()
    {
        try {
            $twig_template = "auth.twig";
            $twig_params = [];

            // If the user isn't authed
            if (!is_null($this->authed_api)) {
                // Get user
                $user = new CollageifyUser($this->authed_api);

                // Validate user timespan
                $validated_timespan = CollageifyValidationService::validateTimeSpan($_POST['term_value'] ?? 'short_term');

                // Get collage
                $collage_service = new CollageGenerationService($user, $validated_timespan, 9);
                $collage_albums = $collage_service->generateCollage();

                // Set params
                $twig_template = "dashboard.twig";
                $twig_params = ['user' => $user, 'collage_albums' => $collage_albums, 'collage_time_frame' => $validated_timespan];
            }

            $this->render($twig_template, $twig_params);
        } catch (SpotifyWebAPIException $e) {
            SpotifyAuthService::logout();
        }
    }

    /**
     * Render twig templates using passed params
     *
     * @param  string $twig_template
     * @param  array $twig_params
     * @return void
     */
    private function render(String $twig_template, array $twig_params)
    {
        echo $this->twig->render('pages/' . $twig_template, $twig_params);
        exit();
    }
}
