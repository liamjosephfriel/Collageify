<?php

use Collageify\Services\CollageGenerationService;

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/app/includes/bootstrapper.php');

$collage_service = new CollageGenerationService($user, 'short_term', 9);
$collage_albums = $collage_service->generateCollage();

echo $twig->render('pages/dashboard.twig', ['user' => $user, 'collage_albums' => $collage_albums]);