<?php
function connect_to_DB(
    $host = 'localhost',
    $username = 'root',
    $password = 'root',
    $database = 'php_formation',
    $port = '3306'
) {
    $connexion = mysqli_connect(
        $host,
        $username,
        $password,
        $database,
        $port
    );

    if ($connexion->connect_errno) {
        die('Connexion échouée : ' . $connexion->connect_error . '<br/>');
    } else {
        echo 'Connexion réussie <br/>';
    }
    return $connexion;
}
