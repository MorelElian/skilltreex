<?php

class Competences
{
    const dbCompetences = "competences";
    const dbLienCompetences = "liencompetence";
    public $idCompetence;
    public $nom;
    public $numeroCompetence;
    public $idChapitre;
    public $descriptif;

    public static function insererCompetence($dbh, $nom, $numeroCompetence, $idChapitre, $descriptif)
    {
        $sth = $dbh->prepare("INSERT INTO `" . self::dbCompetences . "` (`nom`, `numeroCompetence`,`idChapitre`,`descriptif`) VALUES(?,?,?,?)");
        $sth->execute(array($nom, $numeroCompetence, $idChapitre, $descriptif));
    }
    public static function insererLienCompetences($dbh, $numeroCompetencePere, $numeroCompetenceFils)
    {
        $idCompetencePere = Competences::getCompetenceByNumero($dbh, $numeroCompetencePere)->idCompetence;
        $idCompetenceFils = Competences::getCompetenceByNumero($dbh, $numeroCompetenceFils)->idCompetence;

        $sth = $dbh->prepare("INSERT INTO `" . self::dbLienCompetences . "` (`idCompetencePere`, `idCompetenceFils`) VALUES(?,?)");
        $sth->execute(array($idCompetencePere, $idCompetenceFils));
    }
    public static function getAllCompetences($dbh)
    {
        $query = "SELECT * FROM `" . self::dbCompetences . "` as co JOIN `chapitres` as ch on co.idChapitre = ch.idChapitre  WHERE `domaine` = 'Algebre' ";

        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Competences');
        $sth->execute();
        $i = 0;
        while ($competence = $sth->fetch()) {
            $i = $i + 1;
            $tabCompetences[$i] = $competence;
        }
        $sth->closeCursor();
        return $tabCompetences;
    }
    public static function getAllLienCompetences($dbh)
    {
        $query = "SELECT * FROM `" . self::dbLienCompetences . "` WHERE 1 = 1";

        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'LienCompetences');
        $sth->execute();
        $i = 0;
        while ($competence = $sth->fetch()) {
            $i = $i + 1;
            $tabLienCompetences[$i] = $competence;
        }
        $sth->closeCursor();
        return $tabLienCompetences;
    }

    public static function getCompetenceByNumero($dbh, $numeroCompetence)
    {
        $query = "SELECT * FROM `" . self::dbCompetences . "` WHERE `numeroCompetence` = ?";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Competences');
        $sth->execute(array($numeroCompetence));
        $competence = $sth->fetch();
        $sth->closeCursor();
        return $competence;
    }
    public static function getCompetenceById($dbh, $idCompetence)
    {
        $query = "SELECT * FROM `" . self::dbCompetences . "` WHERE `idCompetence` = ?";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Competences');
        $sth->execute(array($idCompetence));
        $competence = $sth->fetch();
        $sth->closeCursor();
        return $competence;
    }
    public static function updateX1Y1($dbh, $x1, $y1, $numeroCompetence)
    {
        $query = "UPDATE `competences` SET `x1`= ?,`y1`=? WHERE `numeroCompetence` = ?";
        $sth = $dbh->prepare($query);
        $sth->execute(array($x1, $y1, $numeroCompetence));
    }

    public static function insererDescriptif($dbh, $numeroCompetence, $descriptif)
    {
        $idCompetence = Competences::getCompetenceByNumero($dbh, $numeroCompetence)->idCompetence;
        $sth = $dbh->prepare("UPDATE `competences` SET `descriptif`=? WHERE `idCompetence` = ?");
        $sth->execute(array($descriptif, $idCompetence,));
    }

    public static function shiftX1Y1($dbh, $x1, $y1, $numeroCompetence)
    {
        $query = "SELECT `x1`,`y1` FROM `competences` WHERE `numeroCompetence` = ?";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode();
        $sth->execute(array($numeroCompetence));
        $tab = $sth->fetch();

        $query = "UPDATE `competences` SET `x1`= ?,`y1`=? WHERE `numeroCompetence` = ?";
        $sth = $dbh->prepare($query);
        $sth->execute(array($tab['x1'] + $x1, $tab['y1'] + $y1, $numeroCompetence));
    }
    public static function getCompetencesPere($dbh, $idCompetence)
    {
        $query = "SELECT * FROM `liencompetence` WHERE `idCompetenceFils` = ?";
        $sth = $dbh->prepare($query);
        $sth->execute(array($idCompetence));
        $tabCompetencePere = array();
        $i = 0;
        while ($comp = $sth->fetch()) {
            $tabCompetencePere[$i] = $comp["idCompetencePere"];
            $i++;
        }
        return $tabCompetencePere;
    }
    public static function getCompetencesFils($dbh, $idCompetence)
    {
        $query = "SELECT * FROM `liencompetence` WHERE `idCompetencePere` = ?";
        $sth = $dbh->prepare($query);
        $sth->execute(array($idCompetence));
        $tabCompetenceFils = array();
        $i = 0;
        while ($comp = $sth->fetch()) {
            $tabCompetenceFils[$i] = $comp["idCompetenceFils"];
            $i++;
        }
        return $tabCompetenceFils;
    }
}
class LienCompetences
{
    public $idCompetencePere;
    public $idCompetenceFils;
}
