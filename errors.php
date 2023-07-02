<?php
if ($erreur_500) {
    header("HTTP/1.0 500 Internal Server Error");
    include("errors/500.html");
    exit;
}

if ($erreur_404) {
    header("HTTP/1.0 404 Not Found");
    include("errors/404.html");
    exit;
}

if ($erreur_403) {
    header("HTTP/1.0 403 Forbidden");
    include("errors/403.html");
    exit;
}
?>