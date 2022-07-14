<?php

class Connaissances
{
    const dbConnaissances = "connaissances";
    public $idConnaissance;
    public $idCompetence;
    public $nomConnaissance;
    
    public static function insererConnaissance($dbh,$numeroCompetence,$nomConnaissance){
        $idCompetence = Competences::getCompetenceByNumero($dbh,$numeroCompetence)->idCompetence;
        $sth = $dbh->prepare("INSERT INTO `connaissances` (`idConnaissance`, `idCompetence`,`nomConnaissance`) VALUES(?,?,?)");
        $sth->execute(array(NULL,$idCompetence,$nomConnaissance));
    }

    public static function getConnaissanceByIdCompetence($dbh,$idCompetence){
        $sth = $dbh->prepare('SELECT * FROM `connaissances` WHERE connaissances.idCompetence = ?'); 
        $tab = [];
        $i = 0;
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Connaissances');
        $sth->execute(array($idCompetence));
        while ($courant =  $sth->fetch()){
            $tab[$i++] = $courant;
        }
        $sth->closeCursor();
        return $tab;
    }
    
}

?>