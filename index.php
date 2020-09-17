<?php
require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/app/includes/bootstrapper.php');

$params = [];
echo $twig->render('pages/auth.twig', $params);