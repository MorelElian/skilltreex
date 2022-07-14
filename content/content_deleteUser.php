<?php 
    function affiche(){
        
        if (!$_SESSION['loggedIn']){
            echo "<p>Connectez vous à un compte avant de vouloir le supprimer.</p>";
        }
        else{
            $dbh = Database::connect();
            $login = $_SESSION['login'];
            $user = Utilisateur::getUtilisateur($dbh, $login);
            if ($user == null){
                echo "<p>Votre compte n'existe pas dans la base de donnée, veuillez changer de compte.</p>";
            }
            else {
                if (array_key_exists('todo',$_GET) && $_GET['todo'] == 'deleteUser'){
                    if(isset($_POST['up'])){
                        $mdp = $_POST['up'];
                        if(!$user->testerMdp($dbh, $mdp)){
                            printDeleteUserForm();
                            echo "<p>Le mot de passe est incorrect.</p>";
                        }
                        else {
                            $query = "DELETE FROM utilisateurs WHERE login=?;";
                            $sth = $dbh->prepare($query);
                            $sth->execute(array($login));
                            logOut();
                            echo "<p>Compte supprimé.</p>";
                        }
                    }
                    else {
                        printDeleteUserForm();
                    }
                    
                }
                else {
                    printDeleteUserForm();
                }
                

            }
        }
    }
?>