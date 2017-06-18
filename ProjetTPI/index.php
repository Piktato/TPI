<?php
session_start();
require './Fonctions/fonctionsDB.php';
require './Fonctions/HtmlToPhp.php';
require './Fonctions/classClassement.php';

$log = "login";
$_SESSION["login"] = $log;
$choixCategorie = 1;
$choixSaison = 1;
$equipe = [];
$match = [];
$_SESSION["triMatchCategorie"] = 1;
$_SESSION["triMatchSaison"] = 1;
$equipeClassement = [];
$tabEquipe = [];
$totalpoint =0 ;
$_SESSION["newSaison"]= 0;



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
    $equipe = getIdEquipeByCategorieSaison( $choixCategorie,$choixSaison);
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
						if($equipe !=null)
						{
							
						
                        $match = getMatchBySaisonCategorie($choixSaison, $equipe[0]["equipe"]);
                        
						
						$equipes = new equipe;
						$tempEquipeName = getEquipeName($choixSaison,$choixCategorie);
						$tempEquipeId = getEquipeClassement($choixSaison,$choixCategorie);
							
						for($i = 0;$i<count($tempEquipeName);$i++)
						{
							$totalpoint =0 ;
							$equipes ->_nomEquipe[$i] = $tempEquipeName[$i]["nom_equipe"];
							$equipes ->_idEquipe[$i] = $tempEquipeId[$i]["equipe"];
							$equipes ->_nbMatch[$i] = nbMatch($equipes ->_idEquipe[$i],$choixSaison);
							
							$match = getMatchBySaisonCategorie($choixSaison, $equipes ->_idEquipe[$i]);
                            foreach ($match as $unMatch) {
                                $noMatch = $unMatch['match'];

                                $temp = CountSetGagneLocal($noMatch,$equipes ->_idEquipe[$i]);
                                $nbSet = $temp[0]["setGagne"];

                                $temp = CountSetGagneVisiteur($noMatch,$equipes ->_idEquipe[$i]);
                                $nbSet += $temp[0]["setGagne"];

								$equipes ->_nbSet[$i] = $nbSet;
								
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
								
								$totalpoint += $nbPoint;
							}
							$equipes ->_nbPts[$i] = $totalpoint;						
							
						}
						
                        
						$equipes->FaireClassement();
						
						$equipes->MettreOrdre();
						echo "<div class=\"col-md-7\">";
						echo "<table>";
						echo "<tr>";
						echo "<td class=\"entetetab\">Nombre de match</td>";
						echo "<td class=\"entetetab\">Nom de l'équipe</td>";
						echo "<td class=\"entetetab\">Nombre de points</td>";
						echo "<td class=\"entetetab\">Classement</td>";
						echo "</tr>";

						
						for($i = 0;$i<count($tempEquipeName);$i++){
							echo "<tr>";
							echo "<td>";
							echo $equipes ->_nbMatch[$i] ;
							echo"</td>";
							echo "<td>";
							echo $equipes ->_nomEquipe[$i] ;
							echo"</td>";
							echo "<td>";
							echo $equipes ->_nbPts[$i] ;
							echo"</td>";
							echo "<td>";
							echo $equipes ->_Classement[$i] ;
							echo"</td>";
							echo "</tr>";
						}
						
						echo"</table>";
						echo"</div>";
						}
						else
						{
							echo "Pas d'équipe dans la catégorie choisie";
						}
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
            <div class="row" >
            <p>Ramushi Ardi Championnat Volley Relax TPI 2017</p>
			</div>
        </footer>



    </body>
</html>
