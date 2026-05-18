<?php
require_once __DIR__ . '/vendor/autoload.php';

$googleClient = new Google\Client();
$googleClient->setAuthConfig(__DIR__ . '/client_secret_309014170368-3i0rthmqcf8ldp7eh0birv3a7ukj8qtu.apps.googleusercontent.com.json');
$googleClient->setRedirectUri('https://localhost/my/ABUAD-Online-Hospital/src/admin/callback.php');
$googleClient->addScope('https://www.googleapis.com/auth/meetings.space.created');
$googleClient->setAccessType('offline');
$googleClient->setPrompt('consent');
