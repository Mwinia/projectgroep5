<?php

// Gegevens voor de database connectie
$host = "localhost";
$user = "u5329p19512_root";
$password = "vuJzn7H9dO";
$database = "u5329p19512_brochure";
$port = "3306";

// Connectie maken
$link = @mysqli_connect($host, $user, $password, $database, $port);

// Connectie controleren
if (!$link) {
    die("De connectie met de database is mislukt. " . mysqli_connect_error());
}
