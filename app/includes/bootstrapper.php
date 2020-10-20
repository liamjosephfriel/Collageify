<?php
/**
 * Bootstrapper file for Collageify
 */

use Collageify\Models\CollageifyUser;
use Collageify\Services\SpotifyAuthService;

// Session
session_start();

// Only load .env on dev environment
if (!isset($_ENV['PROD_ENV']) || !$_ENV['PROD_ENV']) {
    $env_loader = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
    $env_loader->load();
}

// Run auth
$auth_service = new SpotifyAuthService();
$authed_api = $auth_service->auth();

// Get user
$user = new CollageifyUser($authed_api);

// Twig
$loader = new Twig_Loader_Filesystem($_ENV['APP_PATH'] . '/templates/');
$twig = new Twig_Environment($loader);

// Twig functions
$twig->addFunction(new Twig_SimpleFunction('get_env', function($env) {
    return getenv($env);
}));
