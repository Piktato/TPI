<?php
session_start();
require '../Fonctions/fonctionsDB.php';
require '../Fonctions/HtmlToPhp.php';


$log = "login";
$filtre = "1";
$editerMatch = false;
$choixCategorie = 1;
$choixSaison = 1;

if (!(isset($_SESSION["connecter"]))) {
    $_SESSION["connecter"] = false;
}
if (isset($_REQUEST['login'])) {
    header('Location:login.php');
}
if ($_SESSION["connecter"]) {
    $log = "logout";
}
if (isset($_REQUEST['choix1']) && (isset($_REQUEST['filtrer']))) {
    $filtre = $_REQUEST['choix1'];
    $_SESSION["filtre"] = $filtre;
}
if (isset($_REQUEST['logout'])) {
    $_SESSION = [];
    session_destroy();
    $log = "login";
    header('Location:../index.php');
}
if (isset($_GET['editerMatch']) && isset($_GET['id'])) {
    $dataMatch = getMatchById($_GET['id']);
    $_SESSION['editerMatch'] = $_GET['editerMatch'];
    $editerMatch = TRUE;
}
if (isset($_REQUEST["filtrer"])) {
    $choixCategorie = $_REQUEST['SelectCategorie'];
    $choixSaison = $_REQUEST["SelectSaison"];
}



$idCategorie = ""
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../Css/CssTPI.css">
        <link rel="stylesheet" href="../Css/BS/css/bootstrap.css">
        <title>VolleyRelax</title>
    </head>
    <body>
        <div id="corps">

            <form action="calendrier.php" method="post">
                <div class="row">

                    <div class="col-md-offset-1 col-md-1">
                        <img scr="" alt="image">
                    </div>
                    <div class="titre col-md-4">
                        <h1>Championnat Volley Relax</h1>
                    </div>
                    <div class=" col-md-offset-2 col-md-2">

                        <?php echo"<input type=\"submit\" name=$log value=$log>"; ?>

                    </div>
                </div>


                <div class="row bg-success">

                    <?php
                    for ($i = 1; $i < count(getCategorie()); $i++) {
                        $idCategorie = "choix" . $i;
                    }
                    afficherSelectCategorie(getCategorie());
                    afficherSelectSaison(getAnnee());
                    afficherBtn();
                    if ($_SESSION["connecter"]) {
                        afficherCalendrierAdmin(getCalendrierByCategorieSaison($choixCategorie, $choixSaison));
                    } else {
                        afficherCalendrier(getCalendrierByCategorieSaison($choixCategorie, $choixSaison));
                    }
                    ?>

                    <div class="col-md-2">
                        <ul>
                            <li><a href="../index.php">Accueil</a></li>
                            <li><a href="calendrier.php">Calendrier</a></li>
                            <li><a href="match.php">Match</a></li>
                            <li><a href="equipe.php">Equipe</a></li>
                        </ul>
                    </div>
                    <?php
                    if ($editerMatch == TRUE) {
                        editerCalendrier($dataMatch);
                    }
                    if (isset($_REQUEST['btnEditerCalendrier'])) {
                        if (isset($_SESSION['editerMatch'])) {

                            updateCalendrier($_REQUEST["idChanger"], $_REQUEST["dateChanger"]);
                            $_SESSION['editerMatch'] = NULL;
                        }
                    }
                    ?>
                </div>
            </form>
        </div>
        <footer>
            <div class="row" >
            <p>Ramushi Ardi Championnat Volley Relax TPI 2017</p>
			</div>
        </footer>



    </body>
</html>
