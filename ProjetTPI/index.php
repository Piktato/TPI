<?php
session_start();
require './Fonctions/fonctionsDB.php';
require './Fonctions/HtmlToPhp.php';

$filtre = "1";
$log = "login";
$_SESSION["login"] = $log;
$choixCategorie = 1;
$choixSaison = 1;
$equipe = [];
$match = [];



if (!(isset($_SESSION["connecter"]))) {
    $_SESSION["connecter"] = false;
}
if (isset($_REQUEST['login'])) {
    header('Location:Pages/login.php');
}
if ($_SESSION["connecter"]) {
    $log = "logout";
    $_SESSION["login"] = $log;
}
if (isset($_REQUEST['logout'])) {
    $_SESSION = [];
    session_destroy();
    $log = "login";
    header('Location:index.php');
}
if (isset($_REQUEST['filtrer'])) {
    $choixCategorie = $_REQUEST['SelectCategorie'];
    $choixSaison = $_REQUEST["SelectSaison"];
    $_SESSION["Categorie"] = $choixCategorie;
    $_SESSION["Saison"] = $choixSaison;
    $equipe = getEquipeBySaisonCategorie($choixSaison, $choixCategorie);
    $_SESSION["equipe"] = $equipe;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="Css/CssTPI.css">
        <link rel="stylesheet" href="Css/BS/css/bootstrap.css">
        <title>VolleyRelax</title>
    </head>
    <body>
        <div id="corps">

            <form action="index.php" method="post">
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
                    afficherSelectCategorie(getCategorie());
                    afficherSelectSaison(getAnnee());
                    afficherBtn();
                    if (isset($_REQUEST["filtrer"])) {
                        // $equipe contient un tableau avec les points de l'équipe
                        $match = getMatchBySaisonCategorie($choixSaison, $choixCategorie);
                        echo "<div class=\"col-md-7\">";
                        foreach ($equipe as $key => $score) {
                            foreach ($match as $unMatch) {
                                $noMatch = $unMatch['match'];

                                $temp = CountSetGagneLocal($noMatch, $key);
                                $nbSet = $temp[0]["setGagne"];

                                $temp = CountSetGagneVisiteur($noMatch, $key);
                                $nbSet += $temp[0]["setGagne"];

                                $nbTotal = CountSetParMatch($noMatch);

                                if ($nbSet == 3) {
                                    if ($nbTotal < 5)
                                    {
                                        $nbPoint = 3;
                                    }
                                        
                                    else
                                    {
                                        $nbPoint = 2;
                                    }
                                        
                                }
                                else if ($nbSet == 2)
                                {
                                    $nbPoint = 1;
                                    
                                }
                                else
                                {
                                    $nbPoint = 0;
                                }

                                $equipe[$key] += $nbPoint;
                                
                                //echo "<p> " . $noMatch . " $nbPoint $nbSet, $nbTotal  <p>";
                            }
                            afficherChampionnat(getChampionnat($choixSaison,$key),$equipe[$key]);
                        }
                         echo"</div>";
                        
                         
                    }
                    ?>

                    <div class="col-md-2">
                        <ul>
                            <li><a href="index.php">Accueil</a></li>
                            <li><a href="Pages/calendrier.php">Calendrier</a></li>
                            <li><a href="Pages/match.php">Match</a></li>
                            <li><a href="Pages/equipe.php">Equipe</a></li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
        <footer>
            <p>Ramushi Ardi Championnat Volley Relax TPI 2017</p>
        </footer>



    </body>
</html>
