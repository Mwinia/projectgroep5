<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Deze functie controleert of er foutmeldingen zijn
function Fout($input) {
    if (isset($input)) {
        print($input . "<br>");
    }
}

// Deze functie voegt .is-invalid aan een input toe
function IsInvalid($input) {
    if ((isset($input))) {
        print("is-invalid");
    }
}

// Deze functie toont de foutmeldingen
function ToonFoutmeldingen($foutmeldingen) {
    print ("<ul class='foutmeldingen'><li>" . implode('</li><li>', $foutmeldingen) . "</li></ul>");
}

// Deze functie verwerkt de aanvraag van de brochure(s)
function AanvragenBrochure($aanvraag_gegevens) {
    $voornaam = $aanvraag_gegevens["voornaam"];
    $tussenvoegsel = $aanvraag_gegevens["tussenvoegsel"];
    $achternaam = $aanvraag_gegevens["achternaam"];
    $emailadres = $aanvraag_gegevens["emailadres"];
    $opleiding = $aanvraag_gegevens["opleiding"];
    $afstudeerjaar = $aanvraag_gegevens["afstudeerjaar"];

    foreach ($aanvraag_gegevens["interesse"] as $interesse) {
        if (!isset($interesses)) {
            $interesses = "'" . $interesse . "'";
        } else {
            $interesses .= ", " . "'" . $interesse . "'";
        }
    }

    include 'connect.php';
    $stmt = mysqli_prepare($link, "INSERT INTO student (voornaam, tussenvoegsel, achternaam, emailadres, opleiding, afstudeerjaar, interesse) VALUES (?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssssiis", $voornaam, $tussenvoegsel, $achternaam, $emailadres, $opleiding, $afstudeerjaar, $interesses);
    mysqli_stmt_execute($stmt);

    if (mysqli_affected_rows($link) < 1) {
        return "Er is een fout opgetreden: " . mysqli_error($link);
    } else {

        require("./vendor/phpmailer/phpmailer/src/PHPMailer.php");
        require("./vendor/phpmailer/phpmailer/src/SMTP.php");

        //Load Composer's autoloader
        require './vendor/autoload.php';

        $mail = new PHPMailer\PHPMailer\PHPMailer();
        try {
			//Server settings
			$mail->SMTPDebug = 2;                                 // Enable verbose debug output
			$mail->isSMTP();                                      // Set mailer to use SMTP
			$mail->Host = '[fc00:aaaa:bbbb:cccc::14]';  // Specify main and backup SMTP servers
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = 'student@mail.groep4.local';                 // SMTP username
			$mail->Password = 'Groep4!';                           // SMTP password
			$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 25;                                    // TCP port to connect to
	
			//Recipients
            $mail->setFrom('brochure@windesheim.nl', 'Windesheim');
            $mail->addAddress($emailadres);

            $stmt = mysqli_prepare($link, "SELECT pad FROM brochure WHERE afkorting IN (" . $interesses . ")");
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            mysqli_stmt_bind_result($stmt, $pad);

            if (mysqli_stmt_num_rows($stmt) > 0) {
                while (mysqli_stmt_fetch($stmt)) {
                    $mail->addAttachment($pad);
                }
            } else {
                return false;
            }

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Brochure';
            $mail->Body = 'Hallo ' . $voornaam . ',<br><br>Bedankt voor je interesse in een opleiding bij Windesheim.<br><br>Bijgevoegd aan deze mail kun je de opgevraagde brochure(s) vinden.<br><br>Met vriendelijke groeten,<br><br>Windesheim';
            $mail->AltBody = "Hallo " . $voornaam . ",\r\n\r\nBedankt voor je interesse in een opleiding bij Windesheim.\r\n\r\nBijgevoegd aan deze mail kun je de opgevraagde brochure(s) vinden.\r\n\r\nMet vriendelijke groeten,\r\n\r\nWindesheim";

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    mysqli_stmt_free_result($stmt); // Resultset opschonen
    mysqli_stmt_close($stmt); // Statement opruimen
}
