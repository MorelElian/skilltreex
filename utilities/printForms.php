<?php 
    function printLoginForm(){
        echo "<form action='index.php?todo=login&page=connexion' method='POST'>";
        if(isset($_SESSION["Co"]) && !isset($_SESSION["loggedIn"]))
        {
         echo "<div class='alert alert-danger' role='alert'>Identifiant ou mot de passe incorrect </div>";
        }
        echo '<p class="text-black"><input type="text" style="font-size:20px" name="login" placeholder="login" required/></p>';
        echo '<p class="text-black"><input type="password" style="font-size:20px" name="password" placeholder="password" required /></p>';
        echo '<p class="text-black"><input type=submit style="font-size:20px" class="btn btn-success" value="Connexion"></p>';
        echo '</form>';
    }

    function prinLogoutForm(){
        echo "<div style='text-align:right'>";
        echo "<a href='index.php?page=accueil&todo=logout'><input type='submit' value='Deconnexion' class='btn btn-danger'></a>";
        echo "<a href='index.php?page=compte><input type='button' value='Mon compte' class='btn btn-primary'></a>";
        echo "</div>";
    }

    function printRegisterForm(){
        echo <<<CHAINE_DE_FIN
        <div class="row" style="text-align:center; border-radius: 50px">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    
                <div class="card" style="border-radius: 50px">
                    <h5 class="card-header secular bg-danger text-white" style="font-size:30px">Inscription</h5>
                    <div class="card-body bg-dark text-white" style='font-size:20px'>
                        <p class="card-text">Remplis les champs du formulaire pour t'inscrire sur le site</p>
                        <form action="index.php?page=register&todo=register" method=post
                        oninput="up2.setCustomValidity(up2.value != up.value ? 'Les mots de passe diffèrent.' : '')">

                        <p>
                            <input placeholder="Login" type=text required name=login>
                        </p>
        
                        <p>
                            <input placeholder="Nom" type=text required name=nom>
                        </p>

                        <p>
                            <input placeholder="Prénom" type=text required name=prenom>
                        </p>

                        <p>
                            Année du concours
                            <div class="row">
                                <div class="col-sm-5"></div>
                                <div class="col-sm-2">
                                    <select class="form-select" id="anneeConcours" type=int required name=anneeConcours aria-label="Default select example">
                                        <option selected></option>
                                        <option value=2022>2022</option>
                                        <option value=2023>2023</option>
                                        <option value=2024>2024</option>
                                    </select>
                            </div>
                        </p>
                        
                        <div class="row">
                        <div class="col-sm-5"></div>
                        <div class="col-sm-2">
                            <div class="form-check" style="text-align:center">
                                <input class="form-check-input" type="checkbox" value="a" id="flexCheckDefault" name="H4">
                                <label class="form-check-label" for="flexCheckDefault">
                                    H-IV
                                </label>
                            </div>
                        </div>
                    </div>


                        <p>
                            <input placeholder="password" type=password required name=up>
                        </p>
                        
                        <p>
                            <input placeholder="confirm password" type=password name=up2>
                        </p>
        
                        <input type=submit style='font-size:20px' class="btn btn-success" value="Inscription">

                        </form>

                    </div>
                </div>
                </div>
                <div class="col-sm-2"></div>
            </div>
CHAINE_DE_FIN;

    }

    function printChangePasswordForm(){
        echo <<<CHAINE_DE_FIN
        <div class='row' style="margin-top:100px">
            <div class='col-sm-3'></div>
            <div style="text-align:center" class="col-sm-6">
                <div class="card secular">
                    <h5 class="card-header secular bg-warning text-white" style="font-size:30px">Modifier mon mot de passe</h5>
                    <div class="card-body bg-dark text-white" style='font-size:20px'>
                        <form action="?page=changePassword&todo=changePassword" method=post>

                            <p>
                                <input id="password1" placeholder="Ancien mot de passe"type=password required name=up>
                            </p>
            
                            <p>
                                <input id="password2" placeholder="Nouveau mot de passe" type=password name=up2>
                            </p>

                            <p>
                                <input id="password3" placeholder="Nouveau mot de passe" type=password name=up3>
                            </p>
            
                            <input type=submit style='font-size:20px' class="btn btn-success" value="Modifier">
                        </form>
                    </div>
                </div>
            </div>
        </div>
CHAINE_DE_FIN;
    }

    function printDeleteUserForm(){
        $login = $_SESSION['login'];
        echo <<<CHAINE_DE_FIN
        <div class='row' style="margin-top:100px">
            <div class='col-sm-3'></div>
            <div style="text-align:center" class="col-sm-6">
                <div class="card secular">
                    <h5 class="card-header secular bg-danger text-white" style="font-size:30px">Supprimer mon compte</h5>
                    <div class="card-body bg-dark text-white" style='font-size:20px'>
                        <form action="index.php?page=deleteUser&todo=deleteUser" method=post>

                        <p>
                            <input id="password" placeholder="Mot de passe" type=password required name=up>
                        </p>
            
            
                            <input type=submit style='font-size:20px' class="btn btn-danger" value="Supprimer le compte associé au login : $login">
                        </form>
                    </div>
                </div>
            </div>
        </div>
CHAINE_DE_FIN;
    }



?>