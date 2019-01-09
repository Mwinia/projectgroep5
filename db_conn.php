<?php
/* Database credentials. */

<?php
		$db ="mysql:host=192.168.1.189;dbname=webservers;port=3306";
        $user = "root";
        $pass = "Welkom01!";
        $pdo = new PDO($db, $user, $pass);
        
        $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );


        ?>

?>