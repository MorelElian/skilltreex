<?php
class CompetencesUtilisateur
{
    public $idUtilisateur;
    public $idCompetence;
    public $palier;
    const dbCompetencesUtilisateur = "competencesutilisateur";
    const dbCompetences = "competences";

    public static function getAllCompetencesUtilisateur($dbh, $idUtilisateur)
    {
        $query = "SELECT * FROM `" . self::dbCompetencesUtilisateur . "` as coUt JOIN `" . self::dbCompetences . "` as co on co.idCompetence = coUt.idCompetence WHERE coUt.idUtilisateur = ?";

        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'CompetencesUtilisateur');
        $sth->execute(array($idUtilisateur));
        $i = 0;
        $tabCompetencesUtilisateur = array();
        while ($competenceUtilisateur = $sth->fetch()) {
            $i = $i + 1;
            $tabCompetencesUtilisateur[$i] = $competenceUtilisateur;
        }
        $sth->closeCursor();
        return $tabCompetencesUtilisateur;
    }

    public static function returnListCouleur($dbh, $idUtilisateur)
    {
        $tabCompetencesUtilisateur = CompetencesUtilisateur::getAllCompetencesUtilisateur($dbh, $idUtilisateur);
        $tabCouleur = array();

        foreach ($tabCompetencesUtilisateur as $compUt) {


            if ($compUt->palier == 0) {
                $tabCouleur[$compUt->idCompetence] = "#c50111"; #rouge
            } else if ($compUt->palier == 1) {
                $tabCouleur[$compUt->idCompetence] = "#fae100"; #jaune
            } else if ($compUt->palier == 2) {
                $tabCouleur[$compUt->idCompetence] = "#90c90c"; #vert clair
            } else {
                $tabCouleur[$compUt->idCompetence] = "#319203"; #vert foncé
            }
        }
        $tabCompetences = Competences::getAllCompetences($dbh);
        foreach ($tabCompetences as $comp) {
            # var_dump($comp);
            if (!isset($tabCouleur[$comp->idCompetence])) {
                $tabCouleur[$comp->idCompetence] = "#838383";
            }
        }
        return $tabCouleur;
    }
    public static function updateCompetence($dbh, $idEx, $idUtilisateur)
    {
        $query = "SELECT * FROM `exercicescompetence` WHERE `idExercice` = ?;";
        $sth = $dbh->prepare($query);
        $sth->execute(array($idEx));
        $exo = $sth->fetch();
        $sth->closeCursor();
        $query = "SELECT * FROM `competencesutilisateur` WHERE `idUtilisateur` = ? AND `idCompetence` = ?";
        $sth = $dbh->prepare($query);
        $sth->execute(array($idUtilisateur, $exo["idCompetence"]));
        if ($sth->rowCount() == 0) {
            $sth->closeCursor();
            //var_dump($idUtilisateur);
            $query = "INSERT INTO `competencesutilisateur`(`idUtilisateur`, `idCompetence`, `palier`) VALUES (?,?,?)";
            $sth = $dbh->prepare($query);
            $sth->execute(array($idUtilisateur, $exo["idCompetence"], $exo["numeroPalier"]));
        } else {
            $sth->closeCursor();
            $query = "SELECT * FROM `competencesutilisateur` WHERE `idUtilisateur` = ? AND `idCompetence` = ? ";
            $sth = $dbh->prepare($query);
            $sth->execute(array($idUtilisateur, $exo["idCompetence"]));
            $palierUtilisateur = $sth->fetch();
            $sth->closeCursor();
            if ($palierUtilisateur["palier"] < $exo["numeroPalier"]) {
                $query = "UPDATE `competencesutilisateur` SET `palier`= ? WHERE `idCompetence` = ? AND `idUtilisateur` = ?";
                $sth = $dbh->prepare($query);
                $sth->execute(array($exo["numeroPalier"], $exo["idCompetence"], $idUtilisateur));
            }
        }
    }
    public static function verificationCompetence($dbh, $idUtilisateur, $idCompetence)
    {
        $tabCompetencesUtilisateur = CompetencesUtilisateur::getAllCompetencesUtilisateur($dbh, $idUtilisateur);
        $query = "SELECT * FROM `liencompetence` WHERE `idCompetenceFils` = ?";
        $sth = $dbh->prepare($query);
        $sth->execute(array($idCompetence));
        $tabCompetencesNecessaires = array();
        $i = 0;
        while ($compAc = $sth->fetch()) {
            $tabCompetencesNecessaires[$i] = $compAc["idCompetencePere"];
        }
        $verification = true;
        foreach ($tabCompetencesNecessaires as $idCompetencePere) {
            #var_dump($idCompetencePere);
            $flag = false;
            foreach ($tabCompetencesUtilisateur as $compUt) {
                if ($idCompetencePere == $compUt->idCompetence) {
                    $flag = true;
                }
            }
            if (!$flag) {
                $verification = false;
            }
        }
        return $verification;
    }
    public static function verifPalierParent($dbh, $idUtilisateur, $idCompetence, $palier)
    {
        $query = "SELECT * FROM `liencompetence` WHERE `idCompetenceFils` = ?";
        $sth = $dbh->prepare($query);
        $sth->execute(array($idCompetence));
        $tabCompetencesNecessaires = array();
        $i = 0;
        while ($compAc = $sth->fetch()) {
            $tabCompetencesNecessaires[$i] = $compAc["idCompetencePere"];
            $i++;
        }
        $verification = true;
        foreach ($tabCompetencesNecessaires as $idCompetencePere) {
            $query = "SELECT * FROM `competencesutilisateur` WHERE `idCompetence` = ? AND `idUtilisateur` = ?";
            $sth = $dbh->prepare($query);
            $sth->execute(array($idCompetencePere, $idUtilisateur));
            if ($sth->rowCount() == 0) {
                return false;
            }
            $compUt = $sth->fetch();
            $sth->closeCursor();
            if ($compUt["palier"] < $palier) {
                $verification = false;
            }
        }
        return $verification;
    }
    public static function verifPalierPrecedent($dbh, $idUtilisateur, $idCompetence, $palier)
    {
        $query = "SELECT * FROM `competencesutilisateur` WHERE `idUtilisateur` = ? AND `idCompetence` = ?";
        $sth = $dbh->prepare($query);
        $sth->execute(array($idUtilisateur, $idCompetence));
        $tmp =  $sth->fetch();
        //var_dump($tmp);
        if ($sth->rowCount() == 0 || $tmp["palier"] < $palier) {
            //var_dump($palier);
            return false;
        }
        return true;
    }

    public static function insererCompetenceH4($dbh, $login)
    {
        $competenceH4 = array(1, 11, 12, 15, 16, 17, 18);

        $query = "SELECT `idUtilisateur` FROM `utilisateurs` WHERE `login` = ?";
        $sth = $dbh->prepare($query);
        $sth->execute(array($login));
        $idUtilisateur = $sth->fetch()[0];

        foreach ($competenceH4 as $chapitre) {
            $query = "SELECT `idCompetence` FROM `competences` WHERE `idChapitre` = ?";
            $sth = $dbh->prepare($query);
            $sth->execute(array($chapitre));
            while ($comp = $sth->fetch()) {
                $query = "INSERT INTO `competencesutilisateur`(`idUtilisateur`, `idCompetence`, `palier`) VALUES (?,?,?)";
                $sth2 = $dbh->prepare($query);
                $sth2->execute(array($idUtilisateur, $comp[0], 3));
            }
        }
    }
}
