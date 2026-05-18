<?php
session_start();
require_once __DIR__ . '/google_auth.php';

if(isset($_GET['code'])) {
    $token = $googleClient->fetchAccessTokenWithAuthCode($_GET['code']);

    if(isset($token['error'])) {
        die('OAuth error: ' . htmlspecialchars($token['error_description'] ?? $token['error']));
    }

    $_SESSION['google_token'] = $token;

    // Redirect back to the chat page that triggered the auth
    $returnTo = $_SESSION['google_auth_return'] ?? 'https://localhost/my/ABUAD-Online-Hospital/src/admin/view/chat';
    unset($_SESSION['google_auth_return']);
    header("Location: $returnTo");
    exit;
}

die('No authorization code received.');
