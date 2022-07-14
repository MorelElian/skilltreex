<?php 
    function logIn($dbh){
        if (array_key_exists('login',$_POST) && array_key_exists('password',$_POST)){
            $login = $_POST["login"];
            $mdp = $_POST["password"];
            $_SESSION["Co"] = true;
            $user = Utilisateur::getUtilisateur($dbh,$login);
            if ($user == null){
                echo "";
            }
            else {
                if($user->testerMdp($dbh,$mdp)){
                    $_SESSION['loggedIn'] = true;
                    $_SESSION['login'] = $login;
                    $_SESSION['idUtilisateur'] = $user->idUtilisateur;
                    unset($_SESSION["Co"]);
                }
            }
        }
    }
        

    function logOut(){
        $_SESSION['loggedIn'] = false;
        unset($_SESSION['login']);
        unset($_SESSION['loggedIn']);
    }
?>