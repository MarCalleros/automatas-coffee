<?php

function isLogged() {
    if(!isset($_SESSION)) {
        session_start();
    }

    return isset($_SESSION['login']) && $_SESSION['login'] === true;
}

function isAdmin() {
    if(!isset($_SESSION)) {
        session_start();
    }

    return isset($_SESSION['login']) && $_SESSION['login'] === true && isset($_SESSION['id_tipo_usuario']) && ($_SESSION['id_tipo_usuario'] === 1 || $_SESSION['id_tipo_usuario'] === 4);
}

function getLoggedUsername() {
    if (!isset($_SESSION)) {
        session_start();
    }

    return isset($_SESSION['login']) && $_SESSION['login'] === true && isset($_SESSION['usuario']) 
        ? $_SESSION['usuario'] 
        : null;
}

?>