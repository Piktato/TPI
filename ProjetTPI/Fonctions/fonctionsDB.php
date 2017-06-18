<?php

define('DB_HOST', "127.0.0.1");
define('DB_NAME', "volleyrelax");
define('DB_USER', "adminVolley");
define('DB_PASS', "Super");

//Crée la connexion vers la base.
function getConnexion() {
    static $dbb = null;

    if ($dbb === null) {
        $connectionString = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';';
        $dbb = new PDO($connectionString, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
    }
    return $dbb;
}
//Récupère les catégories depuis la base de données.
function getCategorie() {
    $connexion = getConnexion();
    $requete = $connexion->prepare("
		SELECT `nom_categorie` 
		FROM `categorie` "
	);
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}
//Récupère les saisons depuis la base de données.
//Retourne les données sous forme de tableau associatif.
function getAnnee() {
    $connexion = getConnexion();
    $requete = $connexion->prepare("
		SELECT distinct `annee` 
		FROM `match` "
	);
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}
//Récupère le calendrier des matches d'une saison et d'une catégorie donnée.
//Paramètres : $idCategorie , INT ; $annee , INT.
//Retourne les données sous forme de tableau associatif.
function getCalendrierByCategorieSaison($idCategorie,$annee) {
    $connexion = getConnexion();
    $requete = $connexion->prepare(
		"SELECT `id_match`,`date_match`,`annee`,equipe_local.nom_equipe as \"equipe local\", equipe_visiteur.nom_equipe as \"equipe visiteur\",equipe_local.nom_salle,equipe_local.adresse_salle 
		FROM `match` 
		natural join `set`,`categorie` as cat,`equipe` as equipe_local,appartenir as app,`equipe`as equipe_visiteur 
		where equipe_local.id_equipe !=equipe_visiteur.id_equipe 
		and equipe_local.id_equipe = id_equipe_local 
		and equipe_visiteur.id_equipe = id_equipe_visiteur 
		and app.id_categorie = cat.id_categorie 
		and app.id_equipe = id_equipe_local 
		and cat.id_categorie= :idCategorie 
		and annee=:annee 
		group by id_match"
	);
    $requete->bindParam(':idCategorie', $idCategorie, PDO::PARAM_INT);
    $requete->bindParam(':annee', $annee, PDO::PARAM_INT);
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}
//Récupère les matches d'une saison et d'une catégorie donnée.
//Paramètres : $idCategorie , INT ; $annee , INT.
//Retourne les données sous forme de tableau associatif.
function getMatchByCategorieSaison($idCategorie,$annee) {
    $connexion = getConnexion();
    $requete = $connexion->prepare(
		"SELECT `id_set`,`no_set`,date_match,annee,score_local,score_visiteur,
		equipe_local.nom_equipe as \"equipe local\",equipe_visiteur.nom_equipe as \"equipe visiteur\"
		FROM `match` 
		natural join `set`,`categorie` as cat,`equipe` as equipe_local,appartenir as app,`equipe`as equipe_visiteur 
		where equipe_local.id_equipe !=equipe_visiteur.id_equipe 
		and equipe_local.id_equipe = id_equipe_local 
		and equipe_visiteur.id_equipe = id_equipe_visiteur 
		and app.id_categorie = cat.id_categorie 
		and app.id_equipe = id_equipe_local
		and cat.id_categorie= :idCategorie
		and annee= :annee 
		ORDER BY `id_match` ASC, no_set asc "
	);
    $requete->bindParam(':idCategorie', $idCategorie, PDO::PARAM_INT);
	$requete->bindParam(':annee', $annee, PDO::PARAM_INT);
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}
//Récupère le équipes des matches d'une saison et d'une catégorie donnée.
//Paramètres : $idCategorie , INT ; $annee , INT.
//Retourne les données sous forme de tableau associatif.
function getEquipeByCategorieSaison($idCategorie,$annee) {
    $connexion = getConnexion();
    $requete = $connexion->prepare("
		SELECT distinct equipe.id_equipe as \"equipe\",equipe.nom_equipe,equipe.nom_responsable,equipe.mail_responsable,equipe.nom_salle,equipe.adresse_salle 
		FROM `equipe`as equipe 
		natural join categorie as cat , appartenir as app,`match` 
		where cat.id_categorie = app.id_categorie
		and equipe.id_equipe = app.id_equipe 
		and app.id_categorie like :idCategorie 
		and annee = :annee 
		group by equipe.id_equipe "
	);
    $requete->bindParam(':idCategorie', $idCategorie, PDO::PARAM_INT);
    $requete->bindParam(':annee', $annee, PDO::PARAM_INT);
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}
//Récupère les id des équipes d'une saison et d'une catégorie donnée.
//Paramètres : $idCategorie , INT ; $annee , INT.
//Retourne les données sous forme de tableau associatif.
function getIdEquipeByCategorieSaison($idCategorie,$annee) {
    $connexion = getConnexion();
    $requete = $connexion->prepare("
		SELECT distinct equipe.id_equipe as \"equipe\"
		FROM `equipe`as equipe 
		natural join categorie as cat , appartenir as app,`match` 
		where cat.id_categorie = app.id_categorie 
		and equipe.id_equipe = app.id_equipe 
		and app.id_categorie like :idCategorie 
		and annee = :annee 
		group by equipe.id_equipe "
	);
    $requete->bindParam(':idCategorie', $idCategorie, PDO::PARAM_INT);
    $requete->bindParam(':annee', $annee, PDO::PARAM_INT);
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}
//Insert une équipe avec les données des inputs.
//Paramètres : $nomequipe , STR ; $nomresp , STR; $mailresp , STR; $nomsalle , STR; $adressesalle , STR;
function insertEquipe($nomequipe, $nomresp, $mailresp, $nomsalle, $adressesalle) {
    $connexion = getConnexion();
    $requete = $connexion->prepare("
		INSERT INTO `equipe`( `nom_equipe`, `nom_responsable`, `mail_responsable`, `nom_salle`, `adresse_salle`) 
		VALUES (:nomequipe,:nomresp,:mailresp,:nomsalle,:adressesalle)
	");
    $requete->bindParam(':nomequipe', $nomequipe, PDO::PARAM_STR);
    $requete->bindParam(':nomresp', $nomresp, PDO::PARAM_STR);
    $requete->bindParam(':mailresp', $mailresp, PDO::PARAM_STR);
    $requete->bindParam(':nomsalle', $nomsalle, PDO::PARAM_STR);
    $requete->bindParam(':adressesalle', $adressesalle, PDO::PARAM_STR);
    $requete->execute();
}
//Insert la catégorie de la dernière équipe ajoutée.
//Paramètres : $idCategorie , INT.
function insertEquipeIntoCategorie($idCategorie) {
    $connexion = getConnexion();
    $requete = $connexion->prepare("
		INSERT INTO `appartenir`( `id_equipe`,`id_categorie`) 
		VALUES (LAST_INSERT_ID(),:idCategorie)"
	);
    $requete->bindParam(':idCategorie', $idCategorie, PDO::PARAM_INT);
    $requete->execute();
}
//Récupère toutes les informations d'une équipe grâce à son ID.
//Paramètres : $idEquipe , INT .
//Retourne les données sous forme de tableau associatif.
function getEquipeById($idEquipe) {
    $connexion = getConnexion();
    $requete = $connexion->prepare("
		SELECT * 
		FROM `equipe`
		where id_equipe = :idEquipe "
	);
    $requete->bindParam(':idEquipe', $idEquipe, PDO::PARAM_INT);
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}
//Met à jour les information d'une équipe choisie.
//Paramètres : $nomequipe , STR ; $nomresp , STR; $mailresp , STR; $nomsalle , STR; $adressesalle , STR.
function updateEquipe($idEquipe, $nomEquipe, $nomResp, $mailResp, $nomSalle, $adresseSalle) {
    $connexion = getConnexion();
    $requete = $connexion->prepare("
		UPDATE `equipe` 
		SET `nom_equipe`=:nomEquipe,`nom_responsable`=:nomResp,`mail_responsable`=:mailResp,`nom_salle`=:nomSalle,`adresse_salle`=:adresseSalle 
		WHERE `id_equipe`=:idEquipe"
	);
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
//Met à jour la date d'un match choisi.
//Paramètres :$idMatch , INT; $date , STR.
function updateCalendrier($idMatch, $date) {
    $connexion = getConnexion();
    $requete = $connexion->prepare("
		UPDATE `match` 
		SET `date_match`=:date 
		WHERE id_match = :idMatch"
	);
    $requete->bindParam(':date', $date, PDO::PARAM_STR);
    $requete->bindParam(':idMatch', $idMatch, PDO::PARAM_INT);
    $requete->execute();
}
//Récupère toutes les informations d'un match grâce à son ID.
//Paramètres : $idMatch , INT .
//Retourne les données sous forme de tableau associatif.
function getMatchById($idMatch) {
    $connexion = getConnexion();
    $requete = $connexion->prepare("
		SELECT * 
		FROM `match`
		where id_match = :idMatch "
	);
    $requete->bindParam(':idMatch', $idMatch, PDO::PARAM_INT);
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}
//Met à jour le set d'un match choisi.
//Paramètres :$idSet, INT; $score_local, INT, $score_visiteur, INT; $noSet, INT.
function updateSet($idSet, $score_local, $score_visiteur, $noSet) {
    $connexion = getConnexion();
    $requete = $connexion->prepare("
		UPDATE `set` 
		SET `score_local`=:score_local,`score_visiteur`=:score_visiteur,no_set =:noSet 
		WHERE `id_set`=:idSet"
	);
    $requete->bindParam(':score_local', $score_local, PDO::PARAM_INT);
    $requete->bindParam(':score_visiteur', $score_visiteur, PDO::PARAM_INT);
    $requete->bindParam(':noSet', $noSet, PDO::PARAM_INT);
    $requete->bindParam(':idSet', $idSet, PDO::PARAM_INT);
    $requete->execute();
}
//Récupère toutes les informations d'un set grâce à son ID.
//Paramètres : $idSet , INT .
//Retourne les données sous forme de tableau associatif.
function getSetById($idSet) {
    $connexion = getConnexion();
    $requete = $connexion->prepare("
		SELECT * FROM `set`
		where id_set = :idSet "
	);
    $requete->bindParam(':idSet', $idSet, PDO::PARAM_INT);
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}
//Insert un set dans un match choisi grâce à son ID.
//Paramètres : $idSet, INT; $score_local, INT, $score_visiteur, INT; $noSet, INT.
function insertSet($idMatch, $score_local, $score_visiteur, $no_set) {
    $connexion = getConnexion();
    $requete = $connexion->prepare("
		INSERT INTO `set`(`score_local`, `score_visiteur`, `no_set`,`id_match`) 
		VALUES (:sLocal,:sVisiteur,:noSet,:idMatch)
	");
    $requete->bindParam(':sLocal', $score_local, PDO::PARAM_INT);
    $requete->bindParam(':sVisiteur', $score_visiteur, PDO::PARAM_INT);
    $requete->bindParam(':noSet', $no_set, PDO::PARAM_INT);
    $requete->bindParam(':idMatch', $idMatch, PDO::PARAM_INT);
    $requete->execute();
}
//Récupère l'ID d'un match.
//Retourne les données sous forme de tableau associatif.
function getIdMatch() {
    $connexion = getConnexion();
    $requete = $connexion->prepare("
		SELECT `id_match`
		FROM `match`"
	);
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}
//Supprime un set dans une équipe choisie grâce à son ID.
//Paramètres : $idSet, INT.
function DeleteSet($idSet) {
    $connexion = getConnexion();
    $requete = $connexion->prepare("
		DELETE FROM `set` 
		WHERE `id_set`=:idSet"
	);
    $requete->bindParam(':idSet', $idSet, PDO::PARAM_INT);
    $requete->execute();
}
//Insert un match.
//Paramètres : $idEquipeLocal, INT; $idEquipeVisiteur, INT; $annee , INT.
function insertMatch($idEquipeLocal, $idEquipeVisiteur, $annee) {
    $connexion = getConnexion();
    $requete = $connexion->prepare("
		INSERT INTO `match`(`id_equipe_local`, `id_equipe_visiteur`, `annee`) 
		VALUES (:eLocal,:eVisiteur,:annee)"
	);
    $requete->bindParam(':eLocal', $idEquipeLocal, PDO::PARAM_INT);
    $requete->bindParam(':eVisiteur', $idEquipeVisiteur, PDO::PARAM_INT);
    $requete->bindParam(':annee', $annee, PDO::PARAM_INT);
    $requete->execute();
    return ($connexion->lastInsertId());
}
//Récupère la dernière annee ajoutée à la base de données.
//Retourne les données sous forme de tableau associatif.
function getLastAnnee() {
    $connexion = getConnexion();
    $requete = $connexion->prepare("
		SELECT max(annee) as \"LastAnnee\" 
		FROM `match`"
	);
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}
//Insert un set dans le dernier match ajouter.
//Paramètres : $lastId, INT,
function insertSetChampionnat($lastId) {
    $connexion = getConnexion();
    $requete = $connexion->prepare("
		INSERT INTO `set`(`id_match`) 
		VALUES (:lastId)"
	);
    $requete->bindParam(':lastId', $lastId, PDO::PARAM_INT);
    $requete->execute();
}
//Met à jour le set d'un match choisi.
//Paramètres :$idSet, INT; $score_local, INT, $score_visiteur, INT; $noSet, INT.
function updateAppartenir($idEquipe, $idCategorie) {
    $connexion = getConnexion();
    $requete = $connexion->prepare("
		UPDATE `appartenir` 
		SET id_categorie = :idCategorie  
		WHERE `id_equipe`=:idEquipe"
	);
    $requete->bindParam(':idCategorie', $idCategorie, PDO::PARAM_INT);
    $requete->bindParam(':idEquipe', $idEquipe, PDO::PARAM_INT);
    $requete->execute();
}
//Récupère le nombre de set gagné par l'équipe local dans un match grâce à l'ID du match et l'ID de l'équipe.
//Paramètres : $idMatch, INT; $idEquipe , INT.
//Retourne les données sous forme de tableau associatif.
function CountSetGagneLocal($idMatch, $idEquipe) {
    $connexion = getConnexion();
    $requete = $connexion->prepare("
		select count(s.id_set) as \"setGagne\" 
		from equipe e 
		INNER JOIN `match` m ON e.id_equipe = m.id_equipe_local 
		INNER JOIN `set` s ON m.id_match = s.id_match 
		WHERE s.score_local = 25 
		AND e.id_equipe = :idEquipe 
		and m.id_match = :idMatch"
	);
    $requete->bindParam(':idMatch', $idMatch, PDO::PARAM_INT);
    $requete->bindParam(':idEquipe', $idEquipe, PDO::PARAM_INT);
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}
//Récupère le nombre de set joué dans un match grâce à l'ID du match.
//Paramètres : $idMatch, INT; $idEquipe , INT.
//Retourne la valeur directement.
function CountSetParMatch($idMatch) {
    $connexion = getConnexion();
    $requete = $connexion->prepare("
		SELECT count(id_set) as \"nbSet\" 
		FROM `set` 
		WHERE `id_match` = :idMatch"
	);
    $requete->bindParam(':idMatch', $idMatch, PDO::PARAM_INT);
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat[0]["nbSet"];
}
//Récupère le nombre de set gagné par l'équipe visiteur dans un match grâce à l'ID du match et l'ID de l'équipe.
//Paramètres : $idMatch, INT; $idEquipe , INT.
//Retourne les données sous forme de tableau associatif.
function CountSetGagneVisiteur($idMatch, $idEquipe) {
    $connexion = getConnexion();
    $requete = $connexion->prepare("
		select count(s.id_set) as \"setGagne\" 
		from equipe e 
		INNER JOIN `match` m ON e.id_equipe = m.id_equipe_visiteur 
		INNER JOIN `set` s ON m.id_match = s.id_match 
		WHERE s.score_visiteur = 25 
		AND e.id_equipe = :idEquipe 
		and m.id_match = :idMatch"
	);
    $requete->bindParam(':idMatch', $idMatch, PDO::PARAM_INT);
    $requete->bindParam(':idEquipe', $idEquipe, PDO::PARAM_INT);
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}
//Récupère l'ID des matchs d'une saison et d'une équipe donnée.
//Paramètres : $equipe , INT ; $annee , INT.
//Retourne les données sous forme de tableau associatif.
function getMatchBySaisonCategorie($annee, $equipe) {
    $connexion = getConnexion();
    $requete = $connexion->prepare("
		SELECT distinct id_match as \"match\" 
		FROM `match` 
		natural join appartenir as app,equipe as equipe 
		where annee = :annee 
		and app.id_equipe = :equipe 
		and id_equipe_local != id_equipe_visiteur
	");
    $requete->bindParam(':annee', $annee, PDO::PARAM_INT);
    $requete->bindParam(':equipe', $equipe, PDO::PARAM_INT);
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}
//Récupère le nombre de sets joué en local d'une saison et d'une équipe donnée.
//Paramètres : $equipe , INT ; $annee , INT.
//Retourne les données sous forme de tableau associatif.
function nbMatchLocal($equipe,$annee){
	$connexion = getConnexion();
    $requete = $connexion->prepare("
		select count(id_match) as \"nbMatch\" 
		from `match` 
		natural join equipe 
		where  id_equipe = id_equipe_local 
		and id_equipe = :equipe 
		and annee = :annee"
	);
    $requete->bindParam(':equipe', $equipe, PDO::PARAM_INT);
    $requete->bindParam(':annee', $annee, PDO::PARAM_INT);
    $requete->execute();
	$resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
	$nombreMatch =$resultat[0]["nbMatch"];
    return $nombreMatch;
}
//Récupère le nombre de sets joué en visiteur d'une saison et d'une équipe donnée.
//Paramètres : $equipe , INT ; $annee , INT.
//Retourne les données sous forme de tableau associatif.
function nbMatchVisiteur($equipe,$annee){
	$connexion = getConnexion();
    $requete = $connexion->prepare("
		select count(id_match) as\"nbMatch\" 
		from `match` 
		natural join equipe 
		where  id_equipe = id_equipe_visiteur 
		and id_equipe = :equipe 
		and annee = :annee"
	);
    $requete->bindParam(':equipe', $equipe, PDO::PARAM_INT);
    $requete->bindParam(':annee', $annee, PDO::PARAM_INT);
    $requete->execute();
	$resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
	$nombreMatch =$resultat[0]["nbMatch"];
    return $nombreMatch;
}
//Récupère le nombre de matchs d'une saison et d'une équipe donnée.
//Paramètres : $equipe , INT ; $annee , INT.
//Retourne les données sous forme de tableau associatif.
function nbMatch($equipe,$annee){
	$nbMatch = 0;
	$nbMatch = nbMatchLocal($equipe,$annee) + nbMatchVisiteur($equipe,$annee);
	return $nbMatch;
}
//Récupère l'ID des équipes d'une saison et d'une catégorie donnée.
//Paramètres : $categorie , INT ; $annee , INT.
//Retourne les données sous forme de tableau associatif.
function getEquipeClassement($annee, $categorie) {
    $connexion = getConnexion();
    $requete = $connexion->prepare("
		select a.id_equipe as \"equipe\" 
		from appartenir a 
		INNER JOIN `equipe` e ON e.id_equipe = a.id_equipe 
		INNER JOIN `categorie` c ON c.id_categorie = a.id_categorie 
		INNER JOIN `match`m on m.id_equipe_local = a.id_equipe 
		WHERE c.id_categorie = :categorie 
		and annee = :annee 
		group by a.id_equipe"
	);
    $requete->bindParam(':annee', $annee, PDO::PARAM_INT);
    $requete->bindParam(':categorie', $categorie, PDO::PARAM_INT);
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
	return $resultat;
}
//Récupère le nom des équipes d'une saison et d'une catégorie donnée.
//Paramètres : $categorie , INT ; $annee , INT.
//Retourne les données sous forme de tableau associatif.
function getEquipeName($annee,$categorie){
	$connexion = getConnexion();
    $requete = $connexion->prepare("
		SELECT distinct nom_equipe 
		FROM `equipe` e 
		inner join `match` m on m.id_equipe_local = e.id_equipe 
		inner join appartenir a on a.id_equipe = e.id_equipe 
		inner join categorie c on c.id_categorie = a.id_categorie 
		where a.id_equipe = e.id_equipe 
		and a.id_categorie = c.id_categorie
		and c.id_categorie = :categorie 
		and m.annee = :annee"
	);
    $requete->bindParam(':annee', $annee, PDO::PARAM_INT);
	$requete->bindParam(':categorie', $categorie, PDO::PARAM_INT);
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
	return $resultat;
}