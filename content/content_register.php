<?php
//require('classes/Utilisateurs.php');
//require('classes/Database.php');
//require('utilities/printForms.php');
function affiche(){
    if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']){
        echo "<p>Déconnectez vous de ce compte avant de vous inscrire.</p>";
    }
    else{
        if (array_key_exists('todo',$_GET) && $_GET['todo'] == 'register'){
            $form_values_valid=false;
            $dbh = Database::connect();

            if(isset($_POST["login"]) && $_POST["login"] != "" &&
            isset($_POST["nom"]) && $_POST["nom"] != "" &&
            isset($_POST["prenom"]) && $_POST["prenom"] != "" &&
            isset($_POST["up"]) && $_POST["up"] != "" &&
            isset($_POST["up2"]) && $_POST["up2"] != "") {  
                $login = $_POST["login"];
                $nom = $_POST["nom"];
                $prenom = $_POST["prenom"];
                $anneeConcours = $_POST["anneeConcours"];
                $mdp = $_POST["up"];
                $mdp2 = $_POST["up2"];
                if (Utilisateur::getUtilisateur($dbh, $login) == null && $mdp == $mdp2) {
                    $form_values_valid = true;
                    echo "<p class='text-black'>Enregistrement effectué.</p>";
                    Utilisateur::insererUtilisateur($dbh,$login,$mdp,$nom,$prenom,$anneeConcours);
                    if(isset($_POST["H4"]) && $_POST["H4"] == "a"){
                        CompetencesUtilisateur::insererCompetenceH4($dbh,$login);
                    }
                }
                if (!$form_values_valid) {
                    echo "<p class='text-black'>Ce login existe déjà, veuillez le modifier.</p>";
                    printRegisterForm();
                }
            }
            else {
                printRegisterForm();
                
            }
        } 
        else {
            printRegisterForm();
        }
    }
    
}


?>