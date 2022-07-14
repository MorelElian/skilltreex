<?php


class Utilisateur
{
    public $idUtilisateurs;
    public $login;
    public $mdp;
    public $nom;
    public $prenom;
    public $anneeConcours;

    public static function getAllUsers($dbh)
    {
        $query = "SELECT * FROM utilisateurs";
        $tab = array();
        $i = 0;
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Utilisateur');
        $sth->execute();
        while ($courant =  $sth->fetch()) {
            $tab[$i++] = $courant;
        }
        $sth->closeCursor();
        return $tab;
    }

    public static function getUtilisateur($dbh, $login)
    {
        $query = "SELECT * FROM `utilisateurs` WHERE login = ?";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Utilisateur');
        $sth->execute(array($login));
        $user = $sth->fetch();
        $sth->closeCursor();
        return $user;
    }

    public static function insererUtilisateur($dbh, $login, $mdp, $nom, $prenom, $anneeConcours)
    {
        if (Utilisateur::getUtilisateur($dbh, $login) == null) {
            $mdp = password_hash($mdp, PASSWORD_DEFAULT);
            $sth = $dbh->prepare('INSERT INTO `utilisateurs` (`idUtilisateur`, `login`, `mdp`, `nom`, `prenom`, `anneeConcours`, `admin`) VALUES(?,?,?,?,?,?,?)');
            $sth->execute(array(NULL, $login, $mdp, $nom, $prenom, $anneeConcours, '0'));
        }
    }

    public static function getIdUtilisateurByLogin($dbh, $login)
    {
        $sth = $dbh->prepare('SELECT idUtilisateur FROM `utilisateurs` WHERE utilisateurs.login = ?');
        $sth->execute(array($login));
        return $sth->fetch()[0];
    }

    public function testerMdp($dbh, $mdp)
    {
        return password_verify($mdp, $this->mdp);
    }
}
