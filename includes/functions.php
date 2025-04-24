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

    return isset($_SESSION['id_tipo_usuario']) && $_SESSION['id_tipo_usuario'] === 1;
}

?>