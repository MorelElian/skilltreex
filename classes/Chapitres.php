<?php

class Chapitres
{
    const dbChapitres = "chapitres";
    public $idChapitre;
    public $nomChapitre;
    public $domaine;


    public static function insererChapitre($dbh, $nomChapitre, $domaine)
    {
        $sth = $dbh->prepare("INSERT INTO `chapitres` (`nomChapitre`, `domaine`) VALUES(?,?)");
        $sth->execute(array($nomChapitre, $domaine));
    }

    public static function getChapitreById($dbh, $id)
    {
        $query = "SELECT * FROM `" . self::dbChapitres . "` WHERE `idChapitre` = ?";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Chapitres');
        $sth->execute(array($id));
        $competence = $sth->fetch();
        $sth->closeCursor();
        return $competence;
    }
}
