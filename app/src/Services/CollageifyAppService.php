<?php 
namespace Collageify\Services;


use Collageify\Models\CollageifyUser;
use Collageify\Services\SpotifyApiService;
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
        $twig_template = "auth.twig";
        $twig_params = [];

        // If the user isn't authed
        if (!is_null($this->authed_api)) 
        {
            // Get user
            $user = new CollageifyUser($this->authed_api);

            // Get collage
            $collage_service = new CollageGenerationService($user, 'short_term', 9);
            $collage_albums = $collage_service->generateCollage();

            // Set params
            $page_template = "dashboard.twig"; 
            $twig_params = ['user' => $user, 'collage_albums' => $collage_albums];
        }

        $this->render($twig_template, $twig_params);
    }

    private function render(String $twig_template, Array $twig_params) 
    {
        echo $this->twig->render('pages/' . $twig_template, $twig_params);
        exit();
    }
}
