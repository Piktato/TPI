<?php

define('DB_HOST', "127.0.0.1");
define('DB_NAME', "volleyrelax");
define('DB_USER', "adminVolley");
define('DB_PASS', "Super");

function getConnexion() {
    static $dbb = null;

    if ($dbb === null) {
        $connectionString = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';';
        $dbb = new PDO($connectionString, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
    }
    return $dbb;
}

function getMatch() {

    $connexion = getConnexion();
    $requete = $connexion->prepare("SELECT `id_set`,`no_set`,date_match,annee,score_local,score_visiteur,equipe_local.nom_equipe as \"equipe local\",equipe_visiteur.nom_equipe as \"equipe visiteur\"FROM `set` natural join `match`,`equipe` as equipe_local,`equipe`as equipe_visiteur where equipe_local.id_equipe !=equipe_visiteur.id_equipe and equipe_local.id_equipe = id_equipe_local and equipe_visiteur.id_equipe = id_equipe_visiteur ORDER BY `id_match` ASC, no_set asc");
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}

function getCalendrier() {

    $connexion = getConnexion();
    $requete = $connexion->prepare("SELECT `id_match`,`date_match`,`annee`,equipe_local.nom_equipe as \"equipe local\",equipe_visiteur.nom_equipe as \"equipe visiteur\",equipe_local.nom_salle,equipe_local.adresse_salle FROM `match` natural join `equipe` as equipe_local,`equipe`as equipe_visiteur where equipe_local.id_equipe !=equipe_visiteur.id_equipe and equipe_local.id_equipe = id_equipe_local and equipe_visiteur.id_equipe = id_equipe_visiteur");
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}

function getCategorie() {

    $connexion = getConnexion();
    $requete = $connexion->prepare("SELECT `nom_categorie` FROM `categorie` ");
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}

function getAnnee() {

    $connexion = getConnexion();
    $requete = $connexion->prepare("SELECT distinct `annee` FROM `match` ");
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}

function getEquipe() {

    $connexion = getConnexion();
    $requete = $connexion->prepare("SELECT * FROM `equipe` ");
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}

function getCalendrierByCategorieSaison($idCategorie,$annee) {

    $connexion = getConnexion();
    $requete = $connexion->prepare("SELECT `id_match`,`date_match`,`annee`,equipe_local.nom_equipe as \"equipe local\",equipe_visiteur.nom_equipe as \"equipe visiteur\",equipe_local.nom_salle,equipe_local.adresse_salle,nom_categorie FROM `match` natural join `categorie`,`equipe` as equipe_local,`equipe`as equipe_visiteur where equipe_local.id_equipe !=equipe_visiteur.id_equipe and equipe_local.id_equipe = id_equipe_local and equipe_visiteur.id_equipe = id_equipe_visiteur and id_categorie =:idCategorie and annee = :annee");
    $requete->bindParam(':idCategorie', $idCategorie, PDO::PARAM_INT);
    $requete->bindParam(':annee', $annee, PDO::PARAM_INT);
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}

function getMatchByCategorieSaison($idCategorie,$annee) {

    $connexion = getConnexion();
    $requete = $connexion->prepare("SELECT `id_set`,`no_set`,date_match,annee,score_local,score_visiteur,equipe_local.nom_equipe as \"equipe local\",equipe_visiteur.nom_equipe as \"equipe visiteur\"FROM `match` natural join `set`,`categorie`,`equipe` as equipe_local,`equipe`as equipe_visiteur where equipe_local.id_equipe !=equipe_visiteur.id_equipe and equipe_local.id_equipe = id_equipe_local and equipe_visiteur.id_equipe = id_equipe_visiteur and id_categorie=:idCategorie and annee=:annee ORDER BY `id_match` ASC, no_set asc ");
    $requete->bindParam(':idCategorie', $idCategorie, PDO::PARAM_INT);
    $requete->bindParam(':annee', $annee, PDO::PARAM_INT);
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}

function getEquipeByCategorieSaison($idCategorie,$annee) {

    $connexion = getConnexion();
    $requete = $connexion->prepare("SELECT distinct equipe.id_equipe as \"equipe\",equipe.nom_equipe,equipe.nom_responsable,equipe.mail_responsable,equipe.nom_salle,equipe.adresse_salle FROM `equipe`as equipe natural join categorie as cat , appartenir as app,`match` where cat.id_categorie = app.id_categorie and equipe.id_equipe = app.id_equipe and app.id_categorie like :idCategorie and annee = :annee group by equipe.id_equipe ");
    $requete->bindParam(':idCategorie', $idCategorie, PDO::PARAM_INT);
    $requete->bindParam(':annee', $annee, PDO::PARAM_INT);
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}
function getIdEquipeByCategorieSaison($idCategorie,$annee) {

    $connexion = getConnexion();
    $requete = $connexion->prepare("SELECT distinct equipe.id_equipe as \"equipe\"FROM `equipe`as equipe natural join categorie as cat , appartenir as app,`match` where cat.id_categorie = app.id_categorie and equipe.id_equipe = app.id_equipe and app.id_categorie like :idCategorie and annee = :annee group by equipe.id_equipe ");
    $requete->bindParam(':idCategorie', $idCategorie, PDO::PARAM_INT);
    $requete->bindParam(':annee', $annee, PDO::PARAM_INT);
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}

//SELECT equipe.id_equipe as "equipe" FROM `equipe`as equipe natural join categorie as cat , appartenir as app where cat.id_categorie = app.id_categorie and equipe.id_equipe = app.id_equipe and app.id_categorie like 1 group by equipe.id_equipe




function insertEquipe($nomequipe, $nomresp, $mailresp, $nomsalle, $adressesalle) {

    $connexion = getConnexion();
    $requete = $connexion->prepare("INSERT INTO `equipe`( `nom_equipe`, `nom_responsable`, `mail_responsable`, `nom_salle`, `adresse_salle`) VALUES (:nomequipe,:nomresp,:mailresp,:nomsalle,:adressesalle)");
    $requete->bindParam(':nomequipe', $nomequipe, PDO::PARAM_STR);
    $requete->bindParam(':nomresp', $nomresp, PDO::PARAM_STR);
    $requete->bindParam(':mailresp', $mailresp, PDO::PARAM_STR);
    $requete->bindParam(':nomsalle', $nomsalle, PDO::PARAM_STR);
    $requete->bindParam(':adressesalle', $adressesalle, PDO::PARAM_STR);
    $requete->execute();
}

function insertEquipeIntoCategorie($idCategorie) {
    $connexion = getConnexion();
    $requete = $connexion->prepare("INSERT INTO `appartenir`( `id_equipe`,`id_categorie`) VALUES (LAST_INSERT_ID(),:idCategorie)");
    $requete->bindParam(':idCategorie', $idCategorie, PDO::PARAM_INT);
    $requete->execute();
}

function getEquipeById($idEquipe) {

    $connexion = getConnexion();
    $requete = $connexion->prepare("SELECT * FROM `equipe`where id_equipe = :idEquipe ");
    $requete->bindParam(':idEquipe', $idEquipe, PDO::PARAM_INT);
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}

function updateEquipe($idEquipe, $nomEquipe, $nomResp, $mailResp, $nomSalle, $adresseSalle) {
    $connexion = getConnexion();
    $requete = $connexion->prepare("UPDATE `equipe` SET `nom_equipe`=:nomEquipe,`nom_responsable`=:nomResp,`mail_responsable`=:mailResp,`nom_salle`=:nomSalle,`adresse_salle`=:adresseSalle WHERE `id_equipe`=:idEquipe");
    $requete->bindParam(':nomEquipe', $nomEquipe, PDO::PARAM_STR);
    $requete->bindParam(':nomResp', $nomResp, PDO::PARAM_STR);
    $requete->bindParam(':mailResp', $mailResp, PDO::PARAM_STR);
    $requete->bindParam(':nomSalle', $nomSalle, PDO::PARAM_STR);
    $requete->bindParam(':adresseSalle', $adresseSalle, PDO::PARAM_STR);
    $requete->bindParam(':idEquipe', $idEquipe, PDO::PARAM_INT);
    $requete->execute();
}

//function DeleteEquipe($idEquipe) {
//   $connexion = getConnexion();
//   $requete = $connexion->prepare("DELETE FROM `equipe` WHERE `id_equipe`=:idEquipe");
//   $requete->bindParam(':idEquipe', $idEquipe, PDO::PARAM_INT);
//   $requete->execute();
//    
//}
function updateCalendrier($idMatch, $date) {
    $connexion = getConnexion();
    $requete = $connexion->prepare("UPDATE `match` SET `date_match`=:date WHERE id_match = :idMatch");
    $requete->bindParam(':date', $date, PDO::PARAM_STR);
    $requete->bindParam(':idMatch', $idMatch, PDO::PARAM_INT);
    $requete->execute();
}

function getMatchById($idMatch) {
    $connexion = getConnexion();
    $requete = $connexion->prepare("SELECT * FROM `match`where id_match = :idMatch ");
    $requete->bindParam(':idMatch', $idMatch, PDO::PARAM_INT);
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}

function updateSet($idSet, $score_local, $score_visiteur, $noSet) {
    $connexion = getConnexion();
    $requete = $connexion->prepare("UPDATE `set` SET `score_local`=:score_local,`score_visiteur`=:score_visiteur,no_set =:noSet WHERE `id_set`=:idSet");
    $requete->bindParam(':score_local', $score_local, PDO::PARAM_INT);
    $requete->bindParam(':score_visiteur', $score_visiteur, PDO::PARAM_INT);
    $requete->bindParam(':noSet', $noSet, PDO::PARAM_INT);
    $requete->bindParam(':idSet', $idSet, PDO::PARAM_INT);
    $requete->execute();
}

function getSetById($idSet) {
    $connexion = getConnexion();
    $requete = $connexion->prepare("SELECT * FROM `set`where id_set = :idSet ");
    $requete->bindParam(':idSet', $idSet, PDO::PARAM_INT);
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}

function insertSet($idMatch, $score_local, $score_visiteur, $no_set) {
    $connexion = getConnexion();
    $requete = $connexion->prepare("INSERT INTO `set`(`score_local`, `score_visiteur`, `no_set`,`id_match`) VALUES (:sLocal,:sVisiteur,:noSet,:idMatch)");
    $requete->bindParam(':sLocal', $score_local, PDO::PARAM_INT);
    $requete->bindParam(':sVisiteur', $score_visiteur, PDO::PARAM_INT);
    $requete->bindParam(':noSet', $no_set, PDO::PARAM_INT);
    $requete->bindParam(':idMatch', $idMatch, PDO::PARAM_INT);
    $requete->execute();
}

function getIdMatch() {

    $connexion = getConnexion();
    $requete = $connexion->prepare("SELECT `id_match`FROM `match`");
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}

function DeleteSet($idSet) {
    $connexion = getConnexion();
    $requete = $connexion->prepare("DELETE FROM `set` WHERE `id_set`=:idSet");
    $requete->bindParam(':idSet', $idSet, PDO::PARAM_INT);
    $requete->execute();
}

function insertMatch($idEquipeLocal, $idEquipeVisiteur, $annee) {
    $connexion = getConnexion();
    $requete = $connexion->prepare("INSERT INTO `match`(`id_equipe_local`, `id_equipe_visiteur`, `annee`) VALUES (:eLocal,:eVisiteur,:annee)");
    $requete->bindParam(':eLocal', $idEquipeLocal, PDO::PARAM_INT);
    $requete->bindParam(':eVisiteur', $idEquipeVisiteur, PDO::PARAM_INT);
    $requete->bindParam(':annee', $annee, PDO::PARAM_INT);
    $requete->execute();
    return ($connexion->lastInsertId());
}

function getEquipeChampionnat() {

    $connexion = getConnexion();
    $requete = $connexion->prepare("SELECT distinct equipe_local.id_equipe as \"equipe local\",equipe_visiteur.id_equipe as \"equipe visiteur\" FROM `match` natural join `equipe` as equipe_local,`equipe`as equipe_visiteur where equipe_local.id_equipe !=equipe_visiteur.id_equipe and equipe_local.id_equipe = id_equipe_local and equipe_visiteur.id_equipe = id_equipe_visiteur");
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}

function getIdEquipe() {

    $connexion = getConnexion();
    $requete = $connexion->prepare("SELECT id_equipe from equipe");
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}

function getLastAnnee() {
    $connexion = getConnexion();
    $requete = $connexion->prepare("SELECT max(annee) as \"LastAnnee\" FROM `match`");
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}

function insertSetChampionnat($lastId) {
    $connexion = getConnexion();
    $requete = $connexion->prepare("INSERT INTO `set`(`id_match`) VALUES (:lastId)");
    $requete->bindParam(':lastId', $lastId, PDO::PARAM_INT);
    $requete->execute();
}

function updateAppartenir($idEquipe, $idCategorie) {
    $connexion = getConnexion();
    $requete = $connexion->prepare("UPDATE `appartenir` SET id_categorie = :idCategorie  WHERE `id_equipe`=:idEquipe");
    $requete->bindParam(':idCategorie', $idCategorie, PDO::PARAM_INT);
    $requete->bindParam(':idEquipe', $idEquipe, PDO::PARAM_INT);
    $requete->execute();
}

function CountSetGagneLocal($idMatch, $idEquipe) {

    $connexion = getConnexion();
    $requete = $connexion->prepare("select count(s.id_set) as \"setGagne\" from equipe e INNER JOIN `match` m ON e.id_equipe = m.id_equipe_local INNER JOIN `set` s ON m.id_match = s.id_match WHERE s.score_local = 25 AND e.id_equipe = :idEquipe and m.id_match = :idMatch");
    $requete->bindParam(':idMatch', $idMatch, PDO::PARAM_INT);
    $requete->bindParam(':idEquipe', $idEquipe, PDO::PARAM_INT);
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}

function CountSetParMatch($idMatch) {

    $connexion = getConnexion();
    $requete = $connexion->prepare("SELECT count(id_set) as \"nbSet\" FROM `set` WHERE `id_match` = :idMatch");
    $requete->bindParam(':idMatch', $idMatch, PDO::PARAM_INT);
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat[0]["nbSet"];
}

//select count(s.id_set) as "setGagne" from equipe e INNER JOIN `match` m ON e.id_equipe = m.id_equipe_local INNER JOIN `set` s ON m.id_match = s.id_match WHERE s.score_local = 25 AND e.id_equipe = 1


function CountSetGagneVisiteur($idMatch, $idEquipe) {

    $connexion = getConnexion();
    $requete = $connexion->prepare("select count(s.id_set) as \"setGagne\" from equipe e INNER JOIN `match` m ON e.id_equipe = m.id_equipe_visiteur INNER JOIN `set` s ON m.id_match = s.id_match WHERE s.score_visiteur = 25 AND e.id_equipe = :idEquipe and m.id_match = :idMatch");
    $requete->bindParam(':idMatch', $idMatch, PDO::PARAM_INT);
    $requete->bindParam(':idEquipe', $idEquipe, PDO::PARAM_INT);
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}

function getMatchEquipeLocal($idEquipe) {
    $connexion = getConnexion();
    $requete = $connexion->prepare("SELECT id_match FROM `match`natural join `equipe` where id_equipe_local != id_equipe_visiteur and id_equipe_local = id_equipe and id_equipe = :idEquipe");
    $requete->bindParam(':idEquipe', $idEquipe, PDO::PARAM_INT);
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}

//SELECT id_match FROM `match`natural join `equipe` where id_equipe_local != id_equipe_visiteur and id_equipe_local = id_equipe and id_equipe = 1
function getMatchEquipeVisiteur($idEquipe) {
    $connexion = getConnexion();
    $requete = $connexion->prepare("SELECT id_match FROM `match`natural join `equipe` where id_equipe_local != id_equipe_visiteur and id_equipe_visiteur = id_equipe and id_equipe = :idEquipe");
    $requete->bindParam(':idEquipe', $idEquipe, PDO::PARAM_INT);
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}

function getMatchBySaisonCategorie($annee, $equipe) {
    $connexion = getConnexion();
    $requete = $connexion->prepare("SELECT distinct id_match as \"match\" FROM `match` natural join appartenir as app,equipe as equipe where annee = :annee and app.id_equipe = :equipe and id_equipe_local != id_equipe_visiteur");
    $requete->bindParam(':annee', $annee, PDO::PARAM_INT);
    $requete->bindParam(':equipe', $equipe, PDO::PARAM_INT);
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}

function getEquipeBySaisonCategorie($annee, $categorie) {
    $connexion = getConnexion();
    $requete = $connexion->prepare("select a.id_equipe as \"equipe\" from appartenir a INNER JOIN `equipe` e ON e.id_equipe = a.id_equipe INNER JOIN `categorie` c ON c.id_categorie = a.id_categorie INNER JOIN `match`m on m.id_equipe_local = a.id_equipe WHERE c.id_categorie = :categorie and annee = :annee group by a.id_equipe");
    $requete->bindParam(':annee', $annee, PDO::PARAM_INT);
    $requete->bindParam(':categorie', $categorie, PDO::PARAM_INT);
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);

    $scoreEquipe = array();

    foreach ($resultat as $value) {
        $scoreEquipe[$value['equipe']] = 0;
    }
    return $scoreEquipe;
}

function getChampionnat($annee, $equipe) {
    $connexion = getConnexion();
    $requete = $connexion->prepare("select count(m.id_match),l.nom_equipe from `match` m INNER JOIN `equipe` l ON l.id_equipe = m.id_equipe_local INNER JOIN `equipe` v ON v.id_equipe = m.id_equipe_visiteur inner join equipe e on e.id_equipe = :equipe  where l.id_equipe != v.id_equipe and e.id_equipe = :equipe and m.annee = :annee");
    $requete->bindParam(':equipe', $equipe, PDO::PARAM_INT);
    $requete->bindParam(':annee', $annee, PDO::PARAM_INT);
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}
function nbMatchLocal($equipe,$annee){
	$connexion = getConnexion();
    $requete = $connexion->prepare("select count(id_match) as \"nbMatch\" from `match` natural join equipe where  id_equipe = id_equipe_local and id_equipe = :equipe and annee = :annee");
    $requete->bindParam(':equipe', $equipe, PDO::PARAM_INT);
    $requete->bindParam(':annee', $annee, PDO::PARAM_INT);
    $requete->execute();
	$resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
	$nombreMatch =$resultat[0]["nbMatch"];
    return $nombreMatch;
}
function nbMatchVisiteur($equipe,$annee){
	$connexion = getConnexion();
    $requete = $connexion->prepare("select count(id_match) as\"nbMatch\" from `match` natural join equipe where  id_equipe = id_equipe_visiteur and id_equipe = :equipe and annee = :annee");
    $requete->bindParam(':equipe', $equipe, PDO::PARAM_INT);
    $requete->bindParam(':annee', $annee, PDO::PARAM_INT);
    $requete->execute();
	$resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
	$nombreMatch =$resultat[0]["nbMatch"];
    return $nombreMatch;
}
function nbMatch($equipe,$annee){
	$nbMatch = 0;
	$nbMatch = nbMatchLocal($equipe,$annee) + nbMatchVisiteur($equipe,$annee);
	return $nbMatch;
}
function getEquipeClassement($annee, $categorie) {
    $connexion = getConnexion();
    $requete = $connexion->prepare("select a.id_equipe as \"equipe\" from appartenir a INNER JOIN `equipe` e ON e.id_equipe = a.id_equipe INNER JOIN `categorie` c ON c.id_categorie = a.id_categorie INNER JOIN `match`m on m.id_equipe_local = a.id_equipe WHERE c.id_categorie = :categorie and annee = :annee group by a.id_equipe");
    $requete->bindParam(':annee', $annee, PDO::PARAM_INT);
    $requete->bindParam(':categorie', $categorie, PDO::PARAM_INT);
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
	return $resultat;
}
function getEquipeName($annee){
	$connexion = getConnexion();
    $requete = $connexion->prepare("SELECT distinct nom_equipe FROM `equipe` e inner join `match` m on m.id_equipe_local = e.id_equipe inner join appartenir a on a.id_equipe = e.id_equipe inner join categorie c on c.id_categorie = a.id_categorie where m.annee = :annee");
    $requete->bindParam(':annee', $annee, PDO::PARAM_INT);
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
	return $resultat;
	
}


//Select
//SELECT `id_match`,`date_match`,`annee`,equipe_local.nom_equipe,equipe_visiteur.nom_equipe FROM `match` natural join `equipe` as equipe_local,`equipe`as equipe_visiteur where equipe_local.id_equipe !=equipe_visiteur.id_equipe and equipe_local.id_equipe = id_equipe_local and equipe_visiteur.id_equipe = id_equipe_visiteur
//SELECT `no_set`,date_match,annee,score_local,score_visiteur,equipe_local.nom_equipe as "equipe local",equipe_visiteur.nom_equipe as "equipe visiteur"FROM `set` natural join `match`,`equipe` as equipe_local,`equipe`as equipe_visiteur where equipe_local.id_equipe !=equipe_visiteur.id_equipe and equipe_local.id_equipe = id_equipe_local and equipe_visiteur.id_equipe = id_equipe_visiteur
//SELECT `id_match`,`date_match`,`annee`,equipe_local.nom_equipe as "equipe local",equipe_visiteur.nom_equipe as "equipe visiteur",equipe_local.nom_salle,equipe_local.adresse_salle,nom_categorie,no_set,score_local,score_visiteur FROM `match` natural join `set`,`categorie`,`equipe` as equipe_local,`equipe`as equipe_visiteur where equipe_local.id_equipe !=equipe_visiteur.id_equipe and equipe_local.id_equipe = id_equipe_local and equipe_visiteur.id_equipe = id_equipe_visiteur and id_categorie = 1
//SELECT `id_match`,`date_match`,`annee`,equipe_local.nom_equipe as "equipe local",equipe_visiteur.nom_equipe as "equipe visiteur",equipe_local.nom_salle,equipe_local.adresse_salle,nom_categorie FROM `match` natural join `categorie`,`equipe` as equipe_local,`equipe`as equipe_visiteur where equipe_local.id_equipe !=equipe_visiteur.id_equipe and equipe_local.id_equipe = id_equipe_local and equipe_visiteur.id_equipe = id_equipe_visiteur and id_categorie = 1
//Insert
//INSERT INTO `equipe`( `nom_equipe`, `nom_responsable`, `mail_responsable`, `nom_salle`, `adresse_salle`) VALUES ("equipe3","resp3","mail3","salle3","adresse3")
//Update
//UPDATE `set` SET `score_local`=:score_local,`score_visiteur`=:score_visiteur WHERE `id_set`=:idSet
//Championnat
//INSERT INTO `match`( `date_match`, `annee`, `id_equipe_local`, `id_equipe_visiteur`) VALUES (,,,)
//INSERT INTO `set`(`score_local`, `score_visiteur`, `no_set`) VALUES ([value-1],[value-2],[value-3]) where id_match = 1
//SELECT distinct equipe_local.id_equipe as "equipe local",equipe_visiteur.id_equipe as "equipe visiteur" FROM `match` natural join `equipe` as equipe_local,`equipe`as equipe_visiteur where equipe_local.id_equipe !=equipe_visiteur.id_equipe and equipe_local.id_equipe = id_equipe_local and equipe_visiteur.id_equipe = id_equipe_visiteur
//compte le nombre de set avec 25 points
//SELECT count(id_set) as "setGagne" FROM `set` natural join `match`,`equipe` where id_equipe_local != id_equipe_visiteur and id_equipe = id_equipe_local and score_local like 25 and id_match = 1
//SELECT count(id_set) as "setGagne" FROM `set` natural join `match`,`equipe` where id_equipe_local != id_equipe_visiteur and id_equipe = id_equipe_visiteur and score_visiteur like 25 and id_match = 1
