<?php

// Gegevens voor de database connectie
$host = "192.168.1.23";
$user = "root";
$password = "Groep4!";
$database = "brochure";
$port = "3306";

// Connectie maken
$link = @mysqli_connect($host, $user, $password, $database, $port);

// Connectie controleren
if (!$link) {
    die("De connectie met de database is mislukt. " . mysqli_connect_error());
}
