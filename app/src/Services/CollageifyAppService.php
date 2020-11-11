<?php 
namespace Collageify\Services;

use Collageify\Models\CollageifyUser;
use Collageify\Services\SpotifyApiService;
use Collageify\Services\CollageifyValidationService;
use SpotifyWebAPI\SpotifyWebAPIException;
use Twig_Environment;

class CollageifyAppService {

    private $authed_api;
    private $twig;

    public function __construct($authed_api, Twig_Environment $twig)
    {
        $this->authed_api = $authed_api;
        $this->twig = $twig;
    }

    public function run()
    {
        try {
            $twig_template = "auth.twig";
            $twig_params = [];

            // If the user isn't authed
            if (!is_null($this->authed_api)) 
            {
                // Get user
                $user = new CollageifyUser($this->authed_api);

                // Validate user timespan
                $validated_timespan = CollageifyValidationService::validateTimeSpan($_POST['term_value'] ??  'short_term');

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

    private function render(String $twig_template, Array $twig_params) 
    {
        echo $this->twig->render('pages/' . $twig_template, $twig_params);
        exit();
    }
}
