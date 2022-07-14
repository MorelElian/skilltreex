<?php
    function affiche(){
        echo <<<CHAINE_DE_FIN
        <div class="p-3 mb-2 bg-dark text-white secular" style="margin-top:200px; margin-bottom:-100px">
            <h2 style="text-align:center;font-size:50px">Mon Compte</h2>
            <div class="row">
                <div class="col-sm-6">
                    <div class="d-grid gap-2">
                        <a style="font-size:30px" href='?page=changePassword' class='btn btn-outline-warning active btn-block text-white' role='button'>Modifier mon mot de passe</a>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="d-grid gap-2">
                        <a style="font-size:30px" href='?page=deleteUser' class='btn btn-outline-danger active btn-block' role='button'>Supprimer mon compte</a>
                    </div>
                </div>
            </div>
        </div>
CHAINE_DE_FIN;
    }
?>