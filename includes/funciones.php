<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

function isLast(string $actual, string $next) : bool{
    if($actual !== $next) {
        return true;
    }
    return false;
}

function isAdmin() :void{
    if(!isset($_SESSION["admin"])) {
        header("Location: /");
    }
}

// ?Revisar inicio de sesion
function isAuth() : void{
    if(!isset($_SESSION['login'])){
        header('Location: /');
    }
}