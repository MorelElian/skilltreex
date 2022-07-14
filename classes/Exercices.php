<?php

class Exercices
{
    const dbExercices = "exercicescompetence";
    public $idExercice;
    public $nomExercice;
    public $numeroPalier;
    public $idCompetence;

    public static function insererExercice($dbh, $numeroCompetence, $numeroPalier, $numeroExercice)
    {
        $comp = Competences::getCompetenceByNumero($dbh, $numeroCompetence);
        $refExercice = $numeroCompetence . "_Palier" . $numeroPalier . "_" . $numeroExercice;
        $sth = $dbh->prepare("INSERT INTO `" . self::dbExercices . "` (`idExercice`, `nomExercice`,`numeroPalier`,`idCompetence`,`refExercice`) VALUES(?,?,?,?,?)");
        $sth->execute(array(NULL, NULL, $numeroPalier, $comp->idCompetence, $refExercice));
    }

    public static function getExerciceByIdCompetence($dbh, $idCompetence)
    {
        $sth = $dbh->prepare('SELECT * FROM `exercicescompetence` WHERE exercicescompetence.idCompetence = ?');
        $tab = array("0" => array(), "1" => array(), "2" => array(), "3" => array());
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Exercices');
        $sth->execute(array($idCompetence));
        while ($courant =  $sth->fetch()) {
            array_push($tab[$courant->numeroPalier], $courant);
        }
        $sth->closeCursor();
        return $tab;
    }

    public static function getExerciceByIdExercice($dbh, $idExercice)
    {
        $sth = $dbh->prepare('SELECT * FROM `exercicescompetence` WHERE exercicescompetence.idExercice = ?');
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Exercices');
        $sth->execute(array($idExercice));
        return $sth->fetch();
    }

    public static function getNoteUtilisateurByIdExercice($dbh, $idExercice, $idUtilisateur)
    {
        $sth = $dbh->prepare('SELECT lettre FROM `exercicescompetencesutilisateur` WHERE exercicescompetencesutilisateur.idUtilisateur = ? AND exercicescompetencesutilisateur.idExercice = ?');
        $sth->execute(array($idUtilisateur, $idExercice));
        if ($sth->rowCount() == 0) {
            return "F";
        }
        return $sth->fetch()[0];
    }

    public static function boutonExercice($note, $nomExercice, $numero, $idEx, $valid)
    {
        if ($note == "F") {
            $note2 = "";
        } else {
            $note2 = $note;
        }
        if ($valid) {
            echo "<a href='?page=exercice&id=$idEx&numero=$numero' class='btn active bg-$note' role='button' >$numero</a> $note2";
        } else {
            echo "<a href='?page=exercice&id=$idEx' class='btn disabled bg-$note active' role='button' >$numero</a>";
        }
    }

    public static function updateNote($dbh, $idExercice, $idUtilisateur, $note)
    {
        $note0 = Exercices::getNoteUtilisateurByIdExercice($dbh, $idExercice, $idUtilisateur);
        //var_dump($note0);
        if ($note0 == "F") {
            $sth = $dbh->prepare("INSERT INTO `exercicescompetencesutilisateur`(`idExercice`, `idUtilisateur`, `lettre`) VALUES (?,?,?)");
            $sth->execute(array($idExercice, $idUtilisateur, $note));
        } else {
            //var_dump($note);    
            $sth = $dbh->prepare("UPDATE `exercicescompetencesutilisateur` SET `lettre` = ? WHERE idUtilisateur = ? AND idExercice = ?");
            $sth->execute(array($note, $idUtilisateur, $idExercice));
            //var_dump(Exercices::getNoteUtilisateurByIdExercice($dbh,$idExercice,$idUtilisateur));
        }
    }
}
