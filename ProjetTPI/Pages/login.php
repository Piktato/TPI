<?php
session_start();

$mdp = "f6889fc97e14b42dec11a8c183ea791c5465b658"; 
$pseudo = "3b33e00af5d532e64e477278b32e02693afbf2af";
$_SESSION["changementMatch"] = 0;
$_SESSION["changementEquipe"] = 0;
$_SESSION["newSaison"]= 0;
$_SESSION["local"] = [];
$_SESSION["visiteur"] = [];


if(isset($_REQUEST['retour'])){
    header('Location:../index.php');
}
if(isset($_REQUEST['valider']))
{
    if(isset($_REQUEST['pseudo'])&&(isset($_REQUEST['password'])))
    {
        if((sha1($_REQUEST['pseudo'])==$pseudo)&&(sha1($_REQUEST['password'])==$mdp))
        {
           $_SESSION["connecter"] = true;
           $_SESSION["changementMatch"] = 0;
           $_SESSION["changementEquipe"] = 0;
           header('Location:../index.php');
        }
    }
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
        <form action="login.php" method="post">
            <div class="row bg-info">

                <div class="col-md-offset-1 col-md-1">
                    <img scr="" alt="image">
                </div>
                <div class="titre col-md-6">
                    <h1>Championnat Volley Relax</h1>
                </div>

            </div>
            <div class="row bg-info">
                <fieldset id="formulaire">
                    <input type="text" name="pseudo" placeholder="Pseudo">
                    <br>
                    <input type="password" name="password" placeholder="Mot de passe">
                    <br>
                    <input type="submit" name="retour" value="Retour">
                    <input type="submit" name="valider" value="Connexion">
                </fieldset>
            </div>
        </form>
        <?php
        ?>
        <footer>
			<div class="row" >
            <p>Ramushi Ardi Championnat Volley Relax TPI 2017</p>
			</div>
        </footer>
    </body>
</html>
