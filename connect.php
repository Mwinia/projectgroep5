<?php

// Gegevens voor de database connectie
$host = "[fc00:aaaa:bbbb:cccc::13]";
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
