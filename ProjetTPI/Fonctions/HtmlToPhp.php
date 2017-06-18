<?php

/*
Parametre : tableau associatif
Affiche la liste des matchs avec quatre input pour faire des changement.
*/
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

/*
Parametre : tableau associatif
Affiche une liste déroulante avec les catégories.
*/
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

/*
Parametre : tableau associatif
Affiche une liste déroulante avec les saisons.
*/
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

/*
Parametre : tableau associatif
Affiche le calendrier des matchs avec un input pour faire des changements.
*/
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

/*
Parametre : tableau associatif
Affiche le calendrier des matchs.
*/
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
/*
Parametre : tableau associatif
Affiche la liste des matchs.
*/
function afficherListeMatch($tableauAssociatif) {
    echo "<div class=\"col-md-7\">";
    echo "<table>";
    echo "<tr>";
    echo "<td class=\"entetetab\">Numero du Set</td>";
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
/*
Parametre : tableau associatif
Affiche la liste des équipes avec deux input pour faire des changements.
*/
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
/*
Parametre : tableau associatif
Affiche la liste des équipes.
*/
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

/*
Parametre : tableau associatif
Affiche plusieurs input pour ajouter une équipe.
*/
function AddEquipe($tabass) {
    $i = 1;
	echo "<div class =\"col-md-12\">";
	echo "<label>Ajout d'une équipe : </label>";
	echo "</div>";
	echo "<div class=\" col-md-12\">";
    echo "<input class=\"inputediter\" type=\"text\" name=\"nomEquipe\" value=\"\" placeholder=\"Nom de l'équipe\">";
    echo "<input class=\"inputediter\" type=\"text\" name=\"nomResp\" value=\"\" placeholder=\"Nom du responsable\">";
    echo "<input class=\"inputediter\" type=\"text\" name=\"mailResp\" value=\"\" placeholder=\"Mail du responsable\">";
    echo "<input class=\"inputediter\" type=\"text\" name=\"nomSalle\" value=\"\" placeholder=\"Nom de la salle\">";
    echo "<input class=\"inputediter\" type=\"text\" name=\"adresseSalle\" value=\"\" placeholder=\"Adresse de la salle\">";
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
	echo "</div>";
	echo "</div>";
}

/*
Parametre : tableau associatif
Affiche plusieurs input pour éditer la données d'une équipe choisie.
*/
function editerEquipe($dataEquipe, $tabass) {
    $i = 1;
	echo "<div class =\"col-md-12\">";
	echo "<label>Modification de l'équipe".$dataEquipe[0]['id_equipe']." : </label>";
	echo "</div>";
	echo "<div class=\" col-md-12\">";
    echo "<input class=\"inputediter\" type=\"hidden\" name=\"idChanger\" value=\"" . $dataEquipe[0]['id_equipe'] . "\">";
    echo "<input class=\"inputediter\" type=\"text\" name=\"nomEquipeChanger\" value=\"" . $dataEquipe[0]['nom_equipe'] . "\">";
    echo "<input class=\"inputediter\" type=\"text\" name=\"nomRespChanger\" value=\"" . $dataEquipe[0]['nom_responsable'] . "\">";
    echo "<input class=\"inputediter\" type=\"text\" name=\"mailRespChanger\" value=\"" . $dataEquipe[0]['mail_responsable'] . "\">";
    echo "<input class=\"inputediter\" type=\"text\" name=\"nomSalleChanger\" value=\"" . $dataEquipe[0]['nom_salle'] . "\">";
    echo "<input class=\"inputediter\" type=\"text\" name=\"adresseSalleChanger\" value=\"" . $dataEquipe[0]['adresse_salle'] . "\">";
    echo "<select name=\"ChangeCategorie\">";
    foreach ($tabass as $enregistrement) {
        foreach ($enregistrement as $value) {
            echo "<option value=\"$i\">" . $value . "</option>";
            $i++;
        }
    }
    echo '</select>';
    echo "<input type=\"submit\" name=\"btnEditerEquipe\" value=\"Changer\">";
	echo "</div>";
}

//function SupprimerEquipe(){
//    
//    echo "<input type=\"submit\" name=\"btnAnnuler\" value=\"Annuler\">";
//    echo "<input type=\"submit\" name=\"btnsuppEquipe\" value=\"supprimer\">";
//}

/*
Parametre : tableau associatif
Affiche plusieurs input pour éditer la date d'un match choisi.
*/
function editerCalendrier($dataEquipe) {
	echo "<div class =\"col-md-12\">";
	echo "<label>Modification du match".$dataEquipe[0]['id_match']." : </label>";
	echo "</div>";
	echo "<div class=\" col-md-12\">";
    echo "<input class=\"inputediter\" type=\"hidden\" name=\"idChanger\" value=\"" . $dataEquipe[0]['id_match'] . "\">";
    echo "<input class=\"inputediter\" type=\"date\" name=\"dateChanger\" value=\"" . $dataEquipe[0]['date_match'] . "\">";
    echo "<input class=\"inputediter\" type=\"submit\" name=\"btnEditerCalendrier\" value=\"Changer\">";
	echo "</div>";
	
}

/*
Parametre : tableau associatif
Affiche plusieurs input pour éditer les données d'un set choisi.
*/
function editerSet($dataSet) {
	echo "<div class =\"col-md-12\">";
	echo "<label>Modification du set".$dataSet[0]['id_set']." : </label>";
	echo "</div>";
	echo "<div class=\" col-md-12\">";
    echo "<input class=\"inputediter\" type=\"hidden\" name=\"idChanger\" value=\"" . $dataSet[0]['id_set'] . "\">";
    echo "<input class=\"inputediter\" type=\"number\"max=\"5\" min=\"1\" 
			name=\"noSetChanger\"\placeholder=\"n°set\  value=\"" . $dataSet[0]['no_set'] . "\">";
    echo "<input class=\"inputediter\" type=\"number\"max=\"25\" min=\"0\"
			name=\"localChanger\" placeholder=\"Local\" value=\"" . $dataSet[0]['score_local'] . "\">";
    echo "<input class=\"inputediter\" type=\"number\"max=\"25\" min=\"0\" 
			name=\"visiteurChanger\" placeholder=\"Visiteur\" value=\"" . $dataSet[0]['score_visiteur'] . "\">";
    echo "<input type=\"submit\" name=\"btnAnnulerEditerSet\" value=\"Annuler\">";
    echo "<input type=\"submit\" name=\"btnEditerSet\" value=\"Changer\">";
	echo "</div>";
}

/*
Parametre : tableau associatif
Affiche plusieurs input pour ajouter un nouveau set.
*/
function AddSet($tabass) {
    $i = 1;
	echo "<div class =\"col-md-12\">";
	echo "<label>Ajout d'un set : </label>";
	echo "</div>";
	echo "<div class=\" col-md-12\">";
    echo "<input class=\"inputediter\" type=\"number\"max=\"25\" min=\"0\" name=\"sLocal\" value=\"\" placeholder=\"Local\">";
    echo "<input class=\"inputediter\" type=\"number\"max=\"25\" min=\"0\" name=\"sVisiteur\" value=\"\" placeholder=\"Visiteur\">";
    echo "<input class=\"inputediter\" type=\"number\"max=\"5\" min=\"1\" name=\"nSet\" value=\"\" placeholder=\"n°set\">";
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
	echo "</div>";
}

//Afficher deux boutons pour le controle de la suppresion d'un set.
function SupprimerSet() {

    echo "<input type=\"submit\" name=\"btnAnnuler\" value=\"Annuler\">";
    echo "<input type=\"submit\" name=\"btnsuppSet\" value=\"supprimer\">";
}

/*
Parametre : tableau associatif
Affiche plusieurs input pour ajouter une nouvelle saison.
*/
function addSaison($tabass) {
    $i = 1;
	echo "<div class =\"col-md-12\">";
	echo "<label>Ajout d'une saison : </label>";
	echo "</div>";
	echo "<div class=\" col-md-12\">";
    echo "<select name=\"PickCategorie\">";
    foreach ($tabass as $enregistrement) {
        foreach ($enregistrement as $value) {
            echo "<option value=\"$i\">" . $value . "</option>";
            $i++;
        }
    }
    echo '</select>';
    echo "<input class=\"inputediter\" type=\"number\"  min=\"0\"name=\"annee\" value=\"\" placeholder=\"Saison\">";
    echo "<input class=\"inputediter\" type=\"submit\" name=\"btnAnnulerSaison\" value=\"Annuler\">";
    echo "<input class=\"inputediter\" type=\"submit\" name=\"btnAddSaison\" value=\"Ajouter la saison\">";
	echo "</div>";
}
