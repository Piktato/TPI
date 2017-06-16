<?php
session_start();
require '../Fonctions/fonctionsDB.php';
require '../Fonctions/HtmlToPhp.php';


$log = "login";
$filtre = "1";
$addEquipe = false;
$addEquipeDB = false;
$editerEquipe = false;
$supprimerEquipe = true;
$nomEquipe = "";
$nomResp = "";
$mailResp = "";
$salle = "";
$adresse = "";
$nomEquipeChanger = "";
$nomRespChanger = "";
$mailRespChanger = "";
$salleChanger = "";
$adresseChanger = "";
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
if (isset($_REQUEST["ajouterEquipe"])) {
$addEquipe = true;
$_SESSION["changementEquipe"] = 1;
}
if (isset($_REQUEST["nomEquipe"]) && isset($_REQUEST["nomResp"]) && isset($_REQUEST["mailResp"]) && isset($_REQUEST["nomSalle"]) && isset($_REQUEST["adresseSalle"])) {
$addEquipeDB = true;
}
if (isset($_GET['editerEquipe']) && isset($_GET['id'])) {
$dataEquipe = getEquipeByID($_GET['id']);
$_SESSION['editerEquipe'] = $_GET['editerEquipe'];
$editerEquipe = TRUE;
}
if (isset($_REQUEST["filtrer"])) {
    $choixCategorie = $_REQUEST['SelectCategorie'];
    $choixSaison = $_REQUEST["SelectSaison"];
}
//if (isset($_GET['supprimerEquipe']) && isset($_GET['id'])) {
//    $_SESSION['idEquipe'] = $_GET['id'];
//    $_SESSION['supprimerEquipe'] = $_GET['supprimerEquipe'];
//}






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

            <form action="equipe.php" method="post">
                <div class="row ">

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
                    for ($i = 1;
                    $i < count(getCategorie());
                    $i++) {
                    $idCategorie = "choix" . $i;
                    }
                    if ($_SESSION["connecter"]) {
                    afficherListeEquipeAdmin(getEquipe());
                    } else {
                    afficherListeEquipe(getEquipeByCategorieSaison($choixCategorie,$choixSaison));
                    }

                    //afficherListeMatch(getMatch());
                    ?>

                    <div class="col-md-offset-3 col-md-2">
                        <ul>
                            <li><a href="../index.php">Accueil</a></li>
                            <li><a href="calendrier.php">Calendrier</a></li>
                            <li><a href="match.php">Match</a></li>
                            <li><a href="equipe.php">Equipe</a></li>
                        </ul>
                    </div>
                    <?php
                    if ($addEquipe == TRUE) {
                    AddEquipe(getCategorie());
                    $addEquipe = false;
                    }
                    if (isset($_REQUEST['btnAnnulerEquipe'])) {

                    } else {
                    if (isset($_REQUEST["btnAddEquipe"]) && ($_SESSION["changementEquipe"] == 1)) {
                    try {
                    if (($_REQUEST["nomEquipe"] == "") && ($_REQUEST["nomResp"] == "") && ($_REQUEST["mailResp"] == "") && ($_REQUEST["nomSalle"] == "") && ($_REQUEST["adresseSalle"] == "")) {
                    echo "Veuillez remplir les champs";
                    }
                    else
                    { $nomEquipe = filter_input(INPUT_POST, 'nomEquipe', FILTER_SANITIZE_STRING);
                    $nomResp = filter_input(INPUT_POST, 'nomResp', FILTER_SANITIZE_STRING);
                    $mailResp = filter_input(INPUT_POST, 'mailResp', FILTER_SANITIZE_EMAIL);
                    $salle = filter_input(INPUT_POST, 'nomSalle', FILTER_SANITIZE_STRING);
                    $adresse = filter_input(INPUT_POST, 'adresseSalle', FILTER_SANITIZE_STRING);
                    insertEquipe($nomEquipe, $nomResp, $mailRespChanger, $salle, $adresse);
                    insertEquipeIntoCategorie($_REQUEST["addCategorie"]);
                    $addEquipeDB = false;
                    $_SESSION["changementEquipe"] = 0;
                    }
                    } catch (Exception $exc) {
                    echo "mauvaises données";
                    }

                    }
                    }
                    //FILTER_VALIDATE_REGEXP, array("options" => array("regexp" =>$patternMail))
                    if ($editerEquipe == TRUE) {
                    editerEquipe($dataEquipe,getCategorie());
                    }
                    if (isset($_REQUEST['btnEditerEquipe'])) {
                    if (isset($_SESSION['editerEquipe'])) {
                    if (($_REQUEST["nomEquipeChanger"] == "") && ($_REQUEST["nomRespChanger"] == "") && ($_REQUEST["mailRespChanger"] == "") && ($_REQUEST["nomSalleChanger"] == "") && ($_REQUEST["adresseSalleChanger"] == "")) {
                    echo "Veuillez remplir les champs";
                    } else {
                    $nomEquipeChanger = filter_input(INPUT_POST, 'nomEquipeChanger', FILTER_SANITIZE_STRING);
                    $nomRespChanger = filter_input(INPUT_POST, 'nomRespChanger', FILTER_SANITIZE_STRING);
                    $mailRespChanger = filter_input(INPUT_POST, 'mailRespChanger', FILTER_SANITIZE_EMAIL);
                    $salleChanger = filter_input(INPUT_POST, 'nomSalleChanger', FILTER_SANITIZE_STRING);
                    $adresseChanger = filter_input(INPUT_POST, 'adresseSalleChanger', FILTER_SANITIZE_STRING);
                    updateEquipe($_REQUEST["idChanger"], $nomEquipeChanger, $nomRespChanger, $mailRespChanger, $salleChanger, $adresseChanger);
                    updateAppartenir($_REQUEST["idChanger"], $_REQUEST["ChangeCategorie"]);
                    $_SESSION['editerEquipe'] = NULL;
                    }
                    }
                    }
//                    if (isset($_REQUEST['btnAnnuler'])) {                           
//                    } else {
//                        if ($supprimerEquipe == true) {
//                            SupprimerEquipe();
//                            if (isset($_REQUEST['btnsuppEquipe'])) {
//                                DeleteEquipe($_SESSION['idEquipe']);
//                                $supprimerEquipe = false;
//                            }
//                        }
//                    }
                    ?>
                </div>
            </form>
        </div>
        <footer>
            <p>Ramushi Ardi Championnat Volley Relax TPI 2017</p>
        </footer>



    </body>
</html>
