<?php

require_once __DIR__ . "/../models/auth.php";
require_once __DIR__ . "/../core/Server.php";
function auth(): ?Auth {
    $user = null;
    $is_authenticated = false;

    if (!empty($_SESSION['user'])) {
        $user = @ new Auth(...unserialize($_SESSION['user']));
        $is_authenticated = true;
    }

    if (! $is_authenticated) {
        $_SESSION['errors'] = [
            'Unauthenticated!'
        ];
        header(header: 'Location: login.php');
        exit;
    }

    return $user;
}


function guest(): ?bool {
    $is_authenticated = !empty($_SESSION['user']);

    if ($is_authenticated) {
        $_SESSION['errors'] = [
            'Logout, first!'
        ];
        header('Location: index.php');
        exit;
    }

    return true;
}

function server(): ?Server {
    return new Server();
}

