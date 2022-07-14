<?php
class ConcoursCompetences
{
    public $nomConcours;
    public $idCompetence;
    public $palierNecessaire;
    public static function returnListCouleurConcours($dbh,$nomConcours)
    {
        $query = "SELECT * FROM `concourscompetences` WHERE `nomConcours` = ? ";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'ConcoursCompetences');
        $sth->execute(array($nomConcours));
        $tabCouleur = array();
        while($compAct = $sth->fetch())
        {
            if($compAct->palierNecessaire == 0)
            {
                $tabCouleur[$compAct->idCompetence] = "#c50111"; #rouge
            }
            else if($compAct->palierNecessaire == 1)
            {
                $tabCouleur[$compAct->idCompetence] = "#fae100"; #jaune
            }
            else if($compAct->palierNecessaire == 2)
            {
                $tabCouleur[$compAct->idCompetence] = "#90c90c"; #vert clair
            }
            else
            {
                $tabCouleur[$compAct->idCompetence] = "#319203"; #vert foncé
            }
        }
        $tabCompetences = Competences::getAllCompetences($dbh);
        foreach($tabCompetences as $comp)
        {
           # var_dump($comp);
            if(!isset($tabCouleur[$comp->idCompetence]))
            {
                $tabCouleur[$comp->idCompetence] = "#838383";
            }
        }
        return $tabCouleur;
    }
}
?>