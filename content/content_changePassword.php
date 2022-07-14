<?php 
    function affiche(){
        if (!$_SESSION['loggedIn']){
            echo "<p>Connectez vous avant de changer de mot de passe.</p>";
        }
        else{
            $dbh = Database::connect();
            $login = $_SESSION['login'];
            $user = Utilisateur::getUtilisateur($dbh, $login);
            if ($user == null){
                echo "<p>Votre compte n'existe pas dans la base de donnée, veuillez changer de compte.</p>";
            }
            else {
                if (array_key_exists('todo',$_GET) && $_GET['todo'] == 'changePassword'){
                    if(isset($_POST['up']) && isset($_POST['up2']) && isset($_POST['up3'])){
                        $oldMdp = $_POST['up'];
                        $newMdp = $_POST['up2'];
                        $newMdp2 = $_POST['up3'];
                        if(!$user->testerMdp($dbh, $oldMdp)){
                            printChangePasswordForm();
                            echo "<p>L'ancien mot de passe est incorrect.</p>";
                        }
                        else {
                            if ($newMdp != $newMdp2){
                                printChangePasswordForm();
                                echo "<p>Les champs pour le nouveau mot de passe sont différents.</p>";
                            }
                            else{
                                $query = "UPDATE utilisateurs SET mdp=? WHERE login=?";
                                $newMdpHash = password_hash($newMdp,PASSWORD_DEFAULT);
                                $sth = $dbh->prepare($query);
                                $sth->execute(array($newMdpHash,$login));
                                echo "<p>Mot de passe changé avec succès.</p>";
                            }
                        }
                    }
                    else {
                        printChangePasswordForm();
                    }
                    
                }
                else {
                    printChangePasswordForm();
                }
                

            }
        }
    }
?>