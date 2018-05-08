<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Brochure</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="manifest" href="site.webmanifest">
        <link rel="apple-touch-icon" href="icon.png">
        <!-- Place favicon.ico in the root directory -->

        <link rel="stylesheet" href="css/bootstrap.css" crossorigin="anonymous">
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
        <!--[if lte IE 9]>@
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

        <!-- Add your site or application content here -->

        <?php
        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;

        $foutmeldingen = array();

        include 'connect.php';

        include 'functies.php';

        if (isset($_GET['success'])) /* Brochure successvol aangevraagd is */ {
            ?>
            <h2>Je hebt met success een brochure aangevraagd!</h2>
            <p>Check je email om voor de brochure.</p>
            <?php
            exit();
        }

        if (isset($_POST["aanvragen"]) && empty($foutmeldingen)) /* Er op de knop aanvragen geklikt is */ {
            // Controleert of alle verplichte velden ingevuld zijn
            $verplichte_velden = array("voornaam", "achternaam", "emailadres", "opleiding", "afstudeerjaar");

            foreach ($_POST as $i => $waarde) {
                if (empty($waarde) && in_array($i, $verplichte_velden)) {
                    $foutmeldingen[] = "Vul alle verplichte velden in.";
                    break 1;
                }
            }

            if (empty($foutmeldingen)) /* Alle verplichte velden ingevuld zijn */ {
                // Gegevens uit het formulier ophalen
                $voornaam = ucfirst(trim($_POST["voornaam"]));
                $tussenvoegsel = trim($_POST["tussenvoegsel"]);
                $achternaam = ucfirst(trim($_POST["achternaam"]));
                $emailadres = $_POST["emailadres"];
                $opleiding = $_POST["opleiding"];
                $afstudeerjaar = $_POST["afstudeerjaar"];
                $interesse = $_POST["interesse"];

                // Controleert de lengte van de voornaam
                if (strlen($voornaam) < 2 || strlen($voornaam) > 30) {
                    $voornaamfout = "Je voornaam moet minstens 2 en mag maximaal 30 karakters lang zijn.<br>";
                }

                // Controleert de lengte van het tussenvoegsel
                if (!empty($tussenvoegsel) && (strlen($tussenvoegsel) < 2 || strlen($tussenvoegsel) > 10)) {
                    $tussenvoegselfout = "Je tussenvoegsel moet minstens 2 en mag maximaal 10 karakters lang zijn.<br>";
                }

                // Controleert de lengte van de achternaam
                if (strlen($achternaam) < 2 || strlen($achternaam) > 30) {
                    $achternaamfout = "Je achternaam moet minstens 2 en mag maximaal 30 karakters lang zijn.<br>";
                }

                // Controleert of er cijfers in de voornaam zijn gebruikt
                if (preg_match("/[0-9]/", $voornaam)) {
                    if (isset($voornaamfout)) {
                        $voornaamfout .= "Je mag geen cijfers gebruiken in je voornaam.<br>";
                    } else {
                        $voornaamfout = "Je mag geen cijfers gebruiken in je voornaam.<br>";
                    }
                }

                // Controleert of er cijfers in de naam zijn gebruikt
                if (preg_match("/[0-9]/", $tussenvoegsel)) {
                    if (isset($tussenvoegselfout)) {
                        $tussenvoegselfout .= "Je mag geen cijfers gebruiken in je tussenvoegsel.<br>";
                    } else {
                        $tussenvoegselfout = "Je mag geen cijfers gebruiken in je tussenvoegsel.<br>";
                    }
                }

                // Controleert of er cijfers in de naam zijn gebruikt
                if (preg_match("/[0-9]/", $achternaam)) {
                    if (isset($achternaamfout)) {
                        $achternaamfout .= "Je mag geen cijfers gebruiken in je achternaam.<br>";
                    } else {
                        $achternaamfout = "Je mag geen cijfers gebruiken in je achternaam.<br>";
                    }
                }

                // Controleert of er speciale tekens in de naam zijn gebruikt
                if (preg_match("/[!@#$%^&*()_+\=\[\]{};':\"\\|,.<>\/?]/", $voornaam)) {
                    if (isset($voornaamfout)) {
                        $voornaamfout .= "Je mag geen speciale tekens gebruiken in je voornaam.<br>";
                    } else {
                        $voornaamfout = "Je mag geen speciale tekens gebruiken in je voornaam.<br>";
                    }
                }

                // Controleert of er speciale tekens in de naam zijn gebruikt
                if (preg_match("/[!@#$%^&*()_+\=\[\]{};':\"\\|,.<>\/?]/", $tussenvoegsel)) {
                    if (isset($tussenvoegselfout)) {
                        $tussenvoegselfout .= "Je mag geen speciale tekens gebruiken in je tussenvoegsel.<br>";
                    } else {
                        $tussenvoegselfout = "Je mag geen speciale tekens gebruiken in je tussenvoegsel.<br>";
                    }
                }

                // Controleert of er speciale tekens in de naam zijn gebruikt
                if (preg_match("/[!@#$%^&*()_+\=\[\]{};':\"\\|,.<>\/?]/", $achternaam)) {
                    if (isset($achternaamfout)) {
                        $achternaamfout .= "Je mag geen speciale tekens gebruiken in je achternaam.<br>";
                    } else {
                        $achternaamfout = "Je mag geen speciale tekens gebruiken in je achternaam.<br>";
                    }
                }

                // Controleert of de captcha juist is
//                if (!post_captcha($_POST['g-recaptcha-response'])['success']) {
//                    $foutmeldingen[] = "De Captcha is niet juist.";
//                }
            }

            if (empty($foutmeldingen) && !isset($voornaamfout) && !isset($tussenvoegselfout) && !isset($achternaamfout)) {
                $aanvraag_gegevens = array(
                    'voornaam' => $voornaam,
                    'tussenvoegsel' => $tussenvoegsel,
                    'achternaam' => $achternaam,
                    'emailadres' => $emailadres,
                    'opleiding' => $opleiding,
                    'afstudeerjaar' => $afstudeerjaar,
                    'interesse' => $interesse
                );

                if (AanvragenBrochure($aanvraag_gegevens)) {
                    header("Location: index.php?success");
                    exit();
                } else{
                    print ("Er is iets mis gegaan");
                }
            }
        }
        ?>

        <div class="container">
            <h1>Vraag een brochure aan</h1>
            <p>Wil je meer informatie over een opleiding? Vul dan onderstaand formulier in en ontvang de gewenste brochure.</p>
            <p>Ben je jonger dan 16 jaar? Vraag dan eerst toestemming aan één van je ouders of verzorgers om je persoonlijke gegevens hier achter te laten.</p>
            <?php
            if (!empty($foutmeldingen)) {
                ToonFoutmeldingen($foutmeldingen);
                unset($foutmeldingen); // Zodat na het verversen van de pagina de foutmeldingen weg zijn
            }
            ?>
            <form method="post" action="index.php">
                <h3>Vul je persoonlijke gegevens in</h3>
                <div class="form-group row">
                    <label class="col-lg-3 col-md-3 col-sm-4 col-form-label" for="voornaam">Voornaam:<span class="verplicht"></span></label>
                    <div class="col-xl-4 col-lg-4 col-md-7 col-sm-8">
                        <input class="form-control 
                        <?php
                        if ((isset($voornaamfout))) {
                            print("is-invalid");
                        }
                        ?>
                               " type="text" id="voornaam" name="voornaam"
                               <?php
                               if (isset($_POST["voornaam"])) {
                                   print("value='" . trim($_POST["voornaam"]) . "'");
                               }
                               ?>>
                        <div class="invalid-feedback"><?php Fout($voornaamfout) ?></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-md-3 col-sm-4 col-form-label" for="tussenvoegsel">Tussenvoegsel:</label>
                    <div class="col-xl-4 col-lg-4 col-md-7 col-sm-8">
                        <input class="form-control <?php
                        if ((isset($tussenvoegselfout))) {
                            print("is-invalid");
                        }
                        ?>" type="text" id="tussenvoegsel" name="tussenvoegsel"
                               <?php
                               if (isset($_POST["tussenvoegsel"])) {
                                   print("value='" . trim($_POST["tussenvoegsel"]) . "'");
                               }
                               ?>>
                        <div class="invalid-feedback"><?php Fout($tussenvoegselfout) ?></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-md-3 col-sm-4 col-form-label" for="achternaam">Achternaam:<span class="verplicht"></span></label>
                    <div class="col-xl-4 col-lg-4 col-md-7 col-sm-8">
                        <input class="form-control <?php
                        if ((isset($achternaamfout))) {
                            print("is-invalid");
                        }
                        ?>" type="text" id="achternaam" name="achternaam"
                               <?php
                               if (isset($_POST["achternaam"])) {
                                   print("value='" . trim($_POST["achternaam"]) . "'");
                               }
                               ?>>
                        <div class="invalid-feedback"><?php ?></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-md-3 col-sm-4 col-form-label" for="emailadres">E-mailadres:<span class="verplicht"></span></label>
                    <div class="col-xl-4 col-lg-4 col-md-7 col-sm-8">
                        <input class="form-control" type="email" id="emailadres" name="emailadres"
                        <?php
                        if (isset($_POST["emailadres"])) {
                            print("value='" . trim($_POST["emailadres"]) . "'");
                        }
                        ?>>
                    </div>
                </div>
                <h3>Vooropleiding</h3>
                <div class="form-group row">
                    <label class="col-lg-3 col-md-3 col-sm-4 col-form-label" for="opleiding">Opleiding:<span class="verplicht"></span></label>
                    <div class="col-xl-4 col-lg-4 col-md-7 col-sm-8">
                        <select class="form-control" name="opleiding" id="opleiding">
                            <?php
                            // De klassen ophalen voor in het formulier
                            $stmt = mysqli_prepare($link, "SELECT id, naam FROM opleiding ORDER BY naam");
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_store_result($stmt);
                            mysqli_stmt_bind_result($stmt, $id, $naam);

                            if (mysqli_stmt_num_rows($stmt) > 0) {
                                $opleiding = $_POST['opleiding'];
                                if (!empty($opleiding)) {
                                    while (mysqli_stmt_fetch($stmt)) {
                                        if ($opleiding == $id) {
                                            $huidigenaam = $naam;
                                        }
                                    }
                                    print ("<option value='" . $opleiding . "'>" . $huidigenaam . "</option>");
                                } else {
                                    print ("<option value='' selected>Selecteer je opleiding...</option>");
                                }
                                $stmt = mysqli_prepare($link, "SELECT id, naam FROM opleiding ORDER BY naam");
                                mysqli_stmt_execute($stmt);
                                mysqli_stmt_store_result($stmt);
                                mysqli_stmt_bind_result($stmt, $id, $naam);
                                while (mysqli_stmt_fetch($stmt)) {
                                    if ($id != $opleiding) {
                                        print ("<option value='" . $id . "'>" . $naam . "</option>");
                                    }
                                }
                            } else {
                                print ("<option disabled>Geen opleidingen bekend</option>");
                            }

                            mysqli_stmt_free_result($stmt); // Resultset opschonen
                            mysqli_stmt_close($stmt); // Statement opruimen
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-md-3 col-sm-4 col-form-label" for="afstudeerjaar">(Verwacht) afstudeerjaar:<span class="verplicht"></span></label>
                    <div class="col-xl-4 col-lg-4 col-md-7 col-sm-8">
                        <select class="form-control" name="afstudeerjaar" id="afstudeerjaar">
                            <?php
                            // De klassen ophalen voor in het formulier
                            $stmt = mysqli_prepare($link, "SELECT id, jaar FROM afstudeerjaar ORDER BY jaar");
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_store_result($stmt);
                            mysqli_stmt_bind_result($stmt, $id, $jaar);

                            if (mysqli_stmt_num_rows($stmt) > 0) {
                                $afstudeerjaar = $_POST['afstudeerjaar'];
                                if (!empty($afstudeerjaar)) {
                                    while (mysqli_stmt_fetch($stmt)) {
                                        if ($afstudeerjaar == $id) {
                                            $huidigejaar = $jaar;
                                        }
                                    }
                                    print ("<option value='" . $afstudeerjaar . "'>" . $huidigejaar . "</option>");
                                } else {
                                    print ("<option value='' selected>Selecteer je afstudeerjaar...</option>");
                                }
                                $stmt = mysqli_prepare($link, "SELECT id, jaar FROM afstudeerjaar ORDER BY jaar");
                                mysqli_stmt_execute($stmt);
                                mysqli_stmt_store_result($stmt);
                                mysqli_stmt_bind_result($stmt, $id, $jaar);
                                while (mysqli_stmt_fetch($stmt)) {
                                    if ($id != $afstudeerjaar) {
                                        print ("<option value='" . $id . "'>" . $jaar . "</option>");
                                    }
                                }
                            } else {
                                print ("<option disabled>Geen afstudeerjaren bekend</option>");
                            }

                            mysqli_stmt_free_result($stmt); // Resultset opschonen
                            mysqli_stmt_close($stmt); // Statement opruimen
                            ?>
                        </select>
                    </div>
                </div>
                <h3>Kies de gewenste opleidingen</h3>
                <div class="form-group row">
                    <label class="col-lg-3 col-md-3 col-sm-4 col-form-label">Opleiding:<span class="verplicht"></span></label>
                    <div class="col-xl-4 col-lg-4 col-md-7 col-sm-8">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="interesse[]" id="lkn" value="lkn"
                            <?php
                            if (isset($_POST["interesse"]) && is_array($_POST["interesse"])) {
                                if (in_array("lkn", $_POST["interesse"])) {
                                    print("checked");
                                }
                            }
                            ?>>
                            <label class="form-check-label" for="lkn">Laborant Klinische Neurofysiologie</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="interesse[]" id="ta" value="ta" 
                            <?php
                            if (isset($_POST["interesse"]) && is_array($_POST["interesse"])) {
                                if (in_array("ta", $_POST["interesse"])) {
                                    print("checked");
                                }
                            }
                            ?>>
                            <label class="form-check-label" for="ta">Tuinbouw & Agribusiness</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="interesse[]" id="b" value="b" 
                            <?php
                            if (isset($_POST["interesse"]) && is_array($_POST["interesse"])) {
                                if (in_array("b", $_POST["interesse"])) {
                                    print("checked");
                                }
                            }
                            ?>>
                            <label class="form-check-label" for="b">Boomverzorger</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="interesse[]" id="w" value="w" 
                            <?php
                            if (isset($_POST["interesse"]) && is_array($_POST["interesse"])) {
                                if (in_array("w", $_POST["interesse"])) {
                                    print("checked");
                                }
                            }
                            ?>>
                            <label class="form-check-label" for="w">Watermanagement</label>
                        </div>
                    </div>
                </div>

                <p>Bovenstaande gegevens gebruiken we om je eventueel uit te nodigen voor voorlichtingsactiviteiten die daarop aansluiten zoals open dagen. Ook kunnen we je vragen om een enquête over de opleidingsflyers in te vullen.</p>
                <p>Je gegevens worden vertrouwelijk behandeld en niet voor andere doeleinden gebruikt dan bovenstaande.</p>
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-7 col-sm-8 offset-lg-6 offset-md-3 offset-sm-4">
                        <input type="submit" class="btn btn-primary" name="aanvragen" value="Aanvragen"></input>  
                    </div>
                </div>
            </form>
        </div>

        <script src="js/vendor/modernizr-3.5.0.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.2.1.min.js"><\/script>')</script>
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>

        <!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
        <script>
            window.ga = function () {
                ga.q.push(arguments)
            };
            ga.q = [];
            ga.l = +new Date;
            ga('create', 'UA-XXXXX-Y', 'auto');
            ga('send', 'pageview')
        </script>
        <script src="https://www.google-analytics.com/analytics.js" async defer></script>
    </body>
</html>
