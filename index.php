<?php
// Include database connection file
 include "db_conn.php";
 
 // Controleer of gegevens zijn verzonden
 if (isset (filter_input(INPUT_POST,"submit")) {
	
	// Persoonsgegevens definieren
	$voornaam = filter_input(INPUT_POST,"voornaam");
	$achternaam = filter_input(INPUT_POST,"achternaam");
	
	$stmt = $pdo->prepare("INSERT INTO persoon (voornaam, achternaam) VALUES (?, ?)";
	$stmt->execute(array($voornaam, $achternaam));
 }
 
 
 
 <html>
 // Invoervelden voor persoonsgegevens
<form action="add_content.php" method="POST">
 <p>Voornaam: <input type="text" name="voornaam" /></p>
 <p>Achternaam: <input type="text" name="achternaam" /></p>
 <p><input type="submit" /></p>
</form>

</html>