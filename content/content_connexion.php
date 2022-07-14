<?php
function affiche()
{
    if (array_key_exists('loggedIn', $_SESSION) && $_SESSION["loggedIn"]) {
        echo "<div class='bg-success p-2 text-dark bg-opacity-50'>Vous êtes actuellement connecté. Pour se connecter à une autre session, déconnectez-vous d'abord de la session actuelle.</div>";
    } else {
        echo <<<CHAINE_DE_FIN
        <div class='row'>
            <div class='col-sm-2'></div>
            <div style='text-align:center' class='col-sm-8'><h1 class="titre"></h1></div>
            <div class='col-sm-2'></div>";
        </div>
        <div class='row'>
            <div class='col-sm-3'></div>
            <div style="text-align:center" class="col-sm-6">
                <div class="card secular">
                    <h5 class="card-header bg-warning text-black" style="font-size:30px">Connexion</h5>
                    <div class="card-body bg-dark text-white">
CHAINE_DE_FIN;
        printLoginForm();
        echo <<<CHAINE_DE_FIN
                    </div>
                </div>
            </div>
        </div>
CHAINE_DE_FIN;
    }
}
