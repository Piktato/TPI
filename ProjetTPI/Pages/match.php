<?php
session_start();
require '../Fonctions/fonctionsDB.php';
require '../Fonctions/HtmlToPhp.php';


$log = "login";
$filtre = "1";
$editerSet = FALSE;
$addSet = false;
$local = [];
$visiteur = [];
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
if (isset($_GET['editerSet']) && isset($_GET['id'])) {
    $dataSet = getSetById($_GET['id']);
    $_SESSION['editerSet'] = $_GET['editerSet'];
    $editerSet = TRUE;
}
if (isset($_REQUEST["ajouterSet"])) {
    $_SESSION["SetAdded"] = FALSE;
    $_SESSION["changementMatch"] = 1;
    $addSet = true;
} else {
    $_SESSION["SetAdded"] = TRUE;
}
if (isset($_GET['supprimerSet']) && isset($_GET['id'])) {
    $_SESSION['idSet'] = $_GET['id'];
    $_SESSION['supprimerSet'] = $_GET['supprimerSet'];
    $_SESSION["changementMatch"] = 2;
}
if (isset($_REQUEST["newSaison"])) {
    $_SESSION["newSaison"] = 1;
}
if (isset($_REQUEST["filtrer"])) {
    $choixCategorie = $_REQUEST['SelectCategorie'];
    $choixSaison = $_REQUEST["SelectSaison"];
    $_SESSION["triMatchSaison"] = $choixSaison;
	$_SESSION["triMatchCategorie"] =$choixCategorie;
}


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

            <form action="match.php" method="post">
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
                        afficherListeMatchAdmin(getMatchByCategorieSaison($_SESSION["triMatchSaison"],$_SESSION["triMatchCategorie"],getEquipeByCategorieSaison($_SESSION["triMatchSaison"],$_SESSION["triMatchCategorie"])));
                    } else {
                        afficherListeMatch(getMatchByCategorieSaison($_SESSION["triMatchSaison"],$_SESSION["triMatchCategorie"],getEquipeByCategorieSaison($_SESSION["triMatchSaison"],$_SESSION["triMatchCategorie"])));
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
                    if ($addSet == TRUE) {
                        AddSet(getIdMatch());
                        $addSet = false;
                        $_SESSION["newSaison"] = 0;
                    }
                    if (isset($_REQUEST['btnAnnulerSet'])) {
                        
                    } else {
                        if (isset($_REQUEST["btnAddSet"]) && $_SESSION["changementMatch"] == 1) {
                            try {
                                insertSet($_REQUEST["addMatchSet"], $_REQUEST["sLocal"], $_REQUEST["sVisiteur"], $_REQUEST["nSet"]);

                                $addSetDB = false;
                                $_SESSION["changementMatch"] = 0;
                            } catch (Exception $exc) {
                                echo "mauvaise données";
                            }
                        }
                    }
                    if ($editerSet == TRUE) {
                        editerSet($dataSet);
                        $_SESSION["newSaison"] = 0;
                    }
                    if (isset($_REQUEST["btnAnnulerEditerSet"])) {
                        
                    } else {

                        if (isset($_REQUEST['btnEditerSet'])) {
                            if (isset($_SESSION['editerSet'])) {
                                try {
                                    updateSet($_REQUEST["idChanger"], $_REQUEST["localChanger"], $_REQUEST["visiteurChanger"], $_REQUEST["noSetChanger"]);
                                    $_SESSION['editerSet'] = NULL;
                                    $_SESSION["changementMatch"] = FALSE;
                                } catch (Exception $exc) {
                                    echo "Erreur";
                                }
                            }
                        }
                    }
                    if (isset($_REQUEST['btnAnnuler'])) {
                        
                    } else {
                        if (isset($_SESSION["supprimerSet"]) && $_SESSION["changementMatch"] == 2) {
                            SupprimerSet();
                            if (isset($_REQUEST['btnsuppSet'])) {
                                DeleteSet($_SESSION['idSet']);
                                $_SESSION["supprimerSet"] = NULL;
                                $_SESSION["changementMatch"] = 0;
                            }
                        }
                    }

                    if (isset($_REQUEST["btnAnnulerSaison"])) {
                        
                    } else {

                        if (($_SESSION["newSaison"] == 1)) {
                            addSaison(getCategorie());
                            if (isset($_REQUEST["btnAddSaison"])) {
								$annee = getLastAnnee();
                                $local = getEquipeByCategorieSaison($_REQUEST["PickCategorie"],$_REQUEST["annee"]);
                                $visiteur = getEquipeByCategorieSaison($_REQUEST["PickCategorie"],$_REQUEST["annee"]);
								
								echo "<pre>";
								var_dump($local);
								echo "</pre>";
                                for ($j = 0; $j < count($local); $j++) {
                                    for ($k = 0; $k < count($visiteur); $k++) {
                                        if ($visiteur[$k] != $local[$j]) {
                                            $idMatch = insertMatch($local[$j]["equipe"], $visiteur[$k]["equipe"], $_REQUEST["annee"]);

                                            for ($s = 0; $s < 3; $s++) {
                                                insertSetChampionnat($idMatch);
                                            }
                                        }
                                    }
                                }
                                $_SESSION["newSaison"] = 0;
                            }
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
