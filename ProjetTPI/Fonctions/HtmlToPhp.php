<?php

function afficherListeMatchAdmin($tableauAssociatif) {
    echo "<div class=\"col-md-7\">";
    echo "<table>";
    echo "<tr>";
    echo "<td class=\"entetetab\">Id du Set</td>";
    echo "<td class=\"entetetab\">Numero du Set</td>";
    echo "<td class=\"entetetab\">Date du match</td>";
    echo "<td class=\"entetetab\">Annee</td>";
    echo "<td class=\"entetetab\">Score local</td>";
    echo "<td class=\"entetetab\">Score visiteur</td>";
    echo "<td class=\"entetetab\">Nom de l'équipe local</td>";
    echo "<td class=\"entetetab\">Nom de l'équipe visiteur</td>";
    echo "</tr>";
    foreach ($tableauAssociatif as $enregistrement) {
        echo "<tr>";
        $idSet = "";

        foreach ($enregistrement as $value) {
            echo "<td class=\"corpstab\">" . $value . "</td>";

            $idSet = $idSet == "" ? $value : $idSet;
        }

        echo "<td id=\"editer\" style=\" border : solid 1px black\"> <a href=\"?editerSet=true&id=$idSet\"> Editer </a></td>"
        . "<td id=\"supp\" style=\" border : solid 1px black\"><a href=\"?supprimerSet=true&id=$idSet\">Supprimer</a></td>";
    }
    echo "<input type=\"submit\" name=\"newSaison\" value=\"nouvelle saison\"> ";
    echo "<input type=\"submit\" name=\"ajouterSet\" value=\"ajouter un set\">";
    echo"</table>";
    echo"</div>";
}

function afficherSelectCategorie($tabass) {

    $i = 1;
    echo "<div class=\"col-md-1\">";
    echo "<select name=\"SelectCategorie\">";
    foreach ($tabass as $enregistrement) {
        foreach ($enregistrement as $value) {
            echo "<option value=\"$i\">" . $value . "</option>";
            $i++;
        }
    }
    echo '</select>';
    echo "</div>";
}

function afficherSelectSaison($tabass) {

    $i = 1;
    echo "<div class=\"col-md-1\">";
    echo "<select name=\"SelectSaison\">";
    foreach ($tabass as $enregistrement) {
        foreach ($enregistrement as $value) {
            echo "<option value=\"$i\">" . $value . "</option>";
            $i++;
        }
    }
    echo '</select>';
    echo "</div>";
}

function afficherCalendrierAdmin($tableauAssociatif) {
    echo "<div class=\"col-md-7\">";
    echo "<table>";
    echo "<tr>";
    echo "<td class=\"entetetab\">Numero du match</td>";
    echo "<td class=\"entetetab\">Date du match</td>";
    echo "<td class=\"entetetab\">Annee</td>";
    echo "<td class=\"entetetab\">Local</td>";
    echo "<td class=\"entetetab\">Visiteur</td>";
    echo "<td class=\"entetetab\">Nom Salle</td>";
    echo "<td class=\"entetetab\">Adresse Salle</td>";
    echo "</tr>";
    foreach ($tableauAssociatif as $enregistrement) {
        echo "<tr>";
        $idMatch = "";

        foreach ($enregistrement as $value) {
            echo "<td class=\"corpstab\">" . $value . "</td>";

            $idMatch = $idMatch == "" ? $value : $idMatch;
        }

        echo "<td id=\"editer\" style=\" border : solid 1px black\"> <a href=\"?editerMatch=true&id=$idMatch\"> Editer </a></td>";
        echo "</tr>";
    }
    echo"</table>";
    echo"</div>";
}

function afficherCalendrier($tableauAssociatif) {
    echo "<div class=\"col-md-7\">";
    echo "<table>";
    echo "<tr>";
    echo "<td class=\"entetetab\">Numero du match</td>";
    echo "<td class=\"entetetab\">Date du match</td>";
    echo "<td class=\"entetetab\">Annee</td>";
    echo "<td class=\"entetetab\">Local</td>";
    echo "<td class=\"entetetab\">Visiteur</td>";
    echo "<td class=\"entetetab\">Nom Salle</td>";
    echo "<td class=\"entetetab\">Adresse Salle</td>";
    echo "</tr>";
    foreach ($tableauAssociatif as $enregistrement) {
        echo "<tr>";

        foreach ($enregistrement as $value) {
            echo "<td class=\"corpstab\">" . $value . "</td>";
        }
        echo "</tr>";
    }
    echo"</table>";
    echo"</div>";
}

function afficherListeMatch($tableauAssociatif) {
    echo "<div class=\"col-md-7\">";
    echo "<table>";
    echo "<tr>";
    echo "<td class=\"entetetab\">Numero du Set</td>";
    echo "<td class=\"entetetab\">Date du match</td>";
    echo "<td class=\"entetetab\">Annee</td>";
    echo "<td class=\"entetetab\">Score local</td>";
    echo "<td class=\"entetetab\">Score visiteur</td>";
    echo "<td class=\"entetetab\">Nom de l'équipe local</td>";
    echo "<td class=\"entetetab\">Nom de l'équipe visiteur</td>";



    echo "</tr>";
    foreach ($tableauAssociatif as $enregistrement) {
        echo "<tr>";

        foreach ($enregistrement as $value) {
            echo "<td class=\"corpstab\">" . $value . "</td>";
        }
        echo "</tr>";
    }
    echo"</table>";
    echo"</div>";
}

function afficherListeEquipeAdmin($tableauAssociatif) {
    echo "<div class=\"col-md-7\">";
    echo "<table>";
    echo "<tr>";
    echo "<td class=\"entetetab\">Numero de l'équipe</td>";
    echo "<td class=\"entetetab\">Nom de l'équipe</td>";
    echo "<td class=\"entetetab\">Nom du responsable</td>";
    echo "<td class=\"entetetab\">Mail du responsable</td>";
    echo "<td class=\"entetetab\">Nom de la salle</td>";
    echo "<td class=\"entetetab\">Adresse de la salle</td>";
    echo "</tr>";
    foreach ($tableauAssociatif as $enregistrement) {
        echo "<tr>";
        $idEquipe = "";

        foreach ($enregistrement as $value) {
            echo "<td class=\"corpstab\">" . $value . "</td>";

            $idEquipe = $idEquipe == "" ? $value : $idEquipe;
        }

        echo "<td id=\"editer\" style=\" border : solid 1px black\"> <a href=\"?editerEquipe=true&id=$idEquipe\"> Editer </a></td>";
//        . "<td id=\"supp\" style=\" border : solid 1px black\"><a href=\"?supprimerEquipe=true&id=$idEquipe\">Supprimer</a></td>"
        echo "</tr>";
    }
    echo"</table>";
    echo "<input type=\"submit\" name=\"ajouterEquipe\" value=\"ajouter une équipe\">";
    echo"</div>";
}

function afficherListeEquipe($tableauAssociatif) {
    echo "<div class=\"col-md-7\">";
    echo "<table>";
    echo "<tr>";
    echo "<td class=\"entetetab\">Numero de l'équipe</td>";
    echo "<td class=\"entetetab\">Nom de l'équipe</td>";
    echo "<td class=\"entetetab\">Nom du responsable</td>";
    echo "<td class=\"entetetab\">Mail du responsable</td>";
    echo "<td class=\"entetetab\">Nom de la salle</td>";
    echo "<td class=\"entetetab\">Adresse de la salle</td>";
    echo "</tr>";
    foreach ($tableauAssociatif as $enregistrement) {
        echo "<tr>";

        foreach ($enregistrement as $value) {
            echo "<td class=\"corpstab\">" . $value . "</td>";
        }
        echo "</tr>";
    }
    echo"</table>";
    echo"</div>";
}

function afficherBtn() {
    echo "<div class=\"col-md-1\">";
    echo "<input id=\"filtrer\" type=\"submit\" name=\"filtrer\" value=\"Filtrer\">";
    echo"</div>";
}

function AddEquipe($tabass) {
    $i = 1;
    echo "<input type=\"text\" name=\"nomEquipe\" value=\"\" placeholder=\"Nom de l'équipe\">";
    echo "<input type=\"text\" name=\"nomResp\" value=\"\" placeholder=\"Nom du responsable\">";
    echo "<input type=\"text\" name=\"mailResp\" value=\"\" placeholder=\"Mail du responsable\">";
    echo "<input type=\"text\" name=\"nomSalle\" value=\"\" placeholder=\"Nom de la salle\">";
    echo "<input type=\"text\" name=\"adresseSalle\" value=\"\" placeholder=\"Adresse de la salle\">";
    echo "<select name=\"addCategorie\">";
    foreach ($tabass as $enregistrement) {
        foreach ($enregistrement as $value) {
            echo "<option value=\"$i\">" . $value . "</option>";
            $i++;
        }
    }
    echo '</select>';
    echo "<input type=\"submit\" name=\"btnAnnulerEquipe\" value=\"Annuler\">";
    echo "<input type=\"submit\" name=\"btnAddEquipe\" value=\"Ajouter\">";
}

function editerEquipe($dataEquipe, $tabass) {
    $i = 1;
    echo "<input type=\"hidden\" name=\"idChanger\" value=\"" . $dataEquipe[0]['id_equipe'] . "\">";
    echo "<input type=\"text\" name=\"nomEquipeChanger\" value=\"" . $dataEquipe[0]['nom_equipe'] . "\">";
    echo "<input type=\"text\" name=\"nomRespChanger\" value=\"" . $dataEquipe[0]['nom_responsable'] . "\">";
    echo "<input type=\"text\" name=\"mailRespChanger\" value=\"" . $dataEquipe[0]['mail_responsable'] . "\">";
    echo "<input type=\"text\" name=\"nomSalleChanger\" value=\"" . $dataEquipe[0]['nom_salle'] . "\">";
    echo "<input type=\"text\" name=\"adresseSalleChanger\" value=\"" . $dataEquipe[0]['adresse_salle'] . "\">";
    echo "<select name=\"ChangeCategorie\">";
    foreach ($tabass as $enregistrement) {
        foreach ($enregistrement as $value) {
            echo "<option value=\"$i\">" . $value . "</option>";
            $i++;
        }
    }
    echo '</select>';
    echo "<input type=\"submit\" name=\"btnEditerEquipe\" value=\"Changer\">";
}

//function SupprimerEquipe(){
//    
//    echo "<input type=\"submit\" name=\"btnAnnuler\" value=\"Annuler\">";
//    echo "<input type=\"submit\" name=\"btnsuppEquipe\" value=\"supprimer\">";
//}
function editerCalendrier($dataEquipe) {
    echo "<input type=\"hidden\" name=\"idChanger\" value=\"" . $dataEquipe[0]['id_match'] . "\">";
    echo "<input type=\"date\" name=\"dateChanger\" value=\"" . $dataEquipe[0]['date_match'] . "\">";
    echo "<input type=\"submit\" name=\"btnEditerCalendrier\" value=\"Changer\">";
}

function editerSet($dataSet) {
    echo "<input type=\"hidden\" name=\"idChanger\" value=\"" . $dataSet[0]['id_set'] . "\">";

    echo "<label>n°set</label><input type=\"number\"max=\"5\" min=\"1\" name=\"noSetChanger\" \placeholder=\"n°set\  value=\"" . $dataSet[0]['no_set'] . "\">";
    echo "<br>";
    echo "<label>Local</label><input type=\"number\"max=\"25\" min=\"0\" name=\"localChanger\" placeholder=\"Local\" value=\"" . $dataSet[0]['score_local'] . "\">";
    echo "<br>";
    echo "<label>Visiteur</label><input type=\"number\"max=\"25\" min=\"0\" name=\"visiteurChanger\" placeholder=\"Visiteur\" value=\"" . $dataSet[0]['score_visiteur'] . "\">";

    echo "<input type=\"submit\" name=\"btnAnnulerEditerSet\" value=\"Annuler\">";
    echo "<input type=\"submit\" name=\"btnEditerSet\" value=\"Changer\">";
}

function AddSet($tabass) {
    $i = 1;

    echo "<input type=\"number\"max=\"25\" min=\"0\" name=\"sLocal\" value=\"\" placeholder=\"Local\">";
    echo "<input type=\"number\"max=\"25\" min=\"0\" name=\"sVisiteur\" value=\"\" placeholder=\"Visiteur\">";
    echo "<input type=\"number\"max=\"5\" min=\"1\" name=\"nSet\" value=\"\" placeholder=\"n°set\">";
    echo "<select name=\"addMatchSet\">";
    foreach ($tabass as $enregistrement) {
        foreach ($enregistrement as $value) {
            echo "<option value=\"$i\">" . $value . "</option>";
            $i++;
        }
    }
    echo '</select>';
    echo "<input type=\"submit\" name=\"btnAnnulerSet\" value=\"Annuler\">";
    echo "<input type=\"submit\" name=\"btnAddSet\" value=\"Ajouter\">";
}

function SupprimerSet() {

    echo "<input type=\"submit\" name=\"btnAnnuler\" value=\"Annuler\">";
    echo "<input type=\"submit\" name=\"btnsuppSet\" value=\"supprimer\">";
}

function addSaison($tabass) {
    $i = 1;

    echo "<select name=\"PickCategorie\">";
    foreach ($tabass as $enregistrement) {
        foreach ($enregistrement as $value) {
            echo "<option value=\"$i\">" . $value . "</option>";
            $i++;
        }
    }
    echo '</select>';
    echo "<input type=\"number\"  min=\"0\"name=\"annee\" value=\"\" placeholder=\"Saison\">";
    echo "<input type=\"submit\" name=\"btnAnnulerSaison\" value=\"Annuler\">";
    echo "<input type=\"submit\" name=\"btnAddSaison\" value=\"Ajouter la saison\">";
}
function trierClassement($ptsA,$ptsB){
    return strcmp($ptsB["pts"], $ptsA["pts"]);
    
}

function afficherChampionnat($equipes) {
    echo "<table>";
	echo "<tr>";
	echo "<td class=\"entetetab\">Nombre de match</td>";
	echo "<td class=\"entetetab\">Nom de l'équipe</td>";
	echo "<td class=\"entetetab\">Nombre de points</td>";
	echo "<td class=\"entetetab\">Classement</td>";
	echo "</tr>";

	
		for($i = 0;$i<count($equipes);$i++){
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
}