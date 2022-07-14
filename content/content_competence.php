<?php 
    function affiche(){
        if(!array_key_exists('id',$_GET)){
            echo "<p>Aucune page précisée.</p>";
        }
        else {
            global $dbh;
            $id = $_GET['id'];
            $comp = Competences::getCompetenceById($dbh,$id);
            if ($comp == null){
                echo "<p>Identifiant de compétence inconnu.</p>";
            }
            else {
                if(array_key_exists('todo',$_GET) && $_GET['todo'] == 'updateNote'){
                    $idEx = $_GET["idEx"];
                    Exercices::updateNote($dbh,$idEx,$_SESSION['idUtilisateur'],$_POST["note"]);
                    if($_POST["note"] <= "C")
                    {
                    CompetencesUtilisateur::updateCompetence($dbh,$idEx,$_SESSION['idUtilisateur']);
                    }
                }
                $chapitre = Chapitres::getChapitreById($dbh,$comp->idChapitre);
                $tabCompetencePere = Competences::getCompetencesPere($dbh,$id);
                $tabCompetenceFils = Competences::getCompetencesFils($dbh,$id);
                echo <<<CHAINE_DE_FIN
                <div class="row">
                    <h1 style="text-align:center">$chapitre->idChapitre - $chapitre->nomChapitre</h1>
                    <h2 style="text-align:center">$comp->numeroCompetence - $comp->nom</h2>
                    <div class='col-sm-2' style = "padding-left :2em">
                    <h6 style = "width:100%;text-align : center"> Compétence(s) mère(s) </h6> 
                    
CHAINE_DE_FIN;
                foreach($tabCompetencePere as $idCompPere)
                {
                    $titreCompetence = Competences::getCompetenceById($dbh,$idCompPere)->nom;
                    
                    echo "<a href='?page=competence&id=$idCompPere' class='btn btn-secondary active' style = 'margin-bottom : 1em; width:100%' role='button' >< $titreCompetence</a>";
                }
                echo <<<CHAINE_DE_FIN
                    </div>
                    <div class='col-sm-8'>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Descriptif</h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text text-dark">$comp->descriptif</p>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Connaissances</h5>
                            </div>
                            <ul class="list-group list-group-flush">  
CHAINE_DE_FIN;
                $listConnaissance = Connaissances::getConnaissanceByIdCompetence($dbh,$id);
                foreach($listConnaissance as $c){
                    echo "<li class='list-group-item'>- $c->nomConnaissance</li>";
                }
                echo <<<CHAINE_DE_FIN
                            </ul>
                        </div>
                    </div>
                    <div class = 'col-sm-2' style = 'padding-right : 2em'>
                    <h6 style = 'text-align:center;width:100%'> Compétence(s) fille(s) </h6>
CHAINE_DE_FIN;
                foreach($tabCompetenceFils as $idCompFils)
                {
                     $titreCompetence = Competences::getCompetenceById($dbh,$idCompFils)->nom;
                    echo "<a href='?page=competence&id=$idCompFils' class='btn btn-secondary active' style = 'margin-bottom : 1em; width:100%' role='button' > $titreCompetence ></a>";
                }
                echo <<<CHAINE_DE_FIN
                    </div>
                </div>
                <div class="row">
                    <h1 style="text-align:center">Paliers</h1>
CHAINE_DE_FIN;
                $tabExercices = Exercices::getExerciceByIdCompetence($dbh,$id);
                $PalierValide = array();
                $PalierValide[-1] = true;
                $idUser = Utilisateur::getIdUtilisateurByLogin($dbh,$_SESSION["login"]);
                
                
                for($i=0;$i<4;$i++){
                    echo <<<CHAINE_DE_FIN
                    <div class='col-sm-3' style="text-align:center">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Niveau $i</h4>
                            </div>
                            <div class="card-body">
CHAINE_DE_FIN;

                    $flagCompPrec = true;
                    if($i>0 && !CompetencesUtilisateur::verifPalierParent($dbh,$_SESSION["idUtilisateur"],$id,$i))
                    {
                        echo "<div class='alert alert-danger' role='alert'> Vous n'avez pas encore accès à ce niveau : il faut tout d'abord le débloquer dans les compétences précédentes</div>";
                        $flagCompPrec = false;
                    }
                    $flagPalPrec= true;
                    if($i >0 && !CompetencesUtilisateur::verifPalierPrecedent($dbh,$_SESSION["idUtilisateur"],$id,$i-1))
                    {
                        
                        echo "<div class='alert alert-danger' role='alert'> Vous n'avez pas encore accès à ce niveau : il faut tout d'abord réussir un exo du palier précédent </div>";
                        $flagPalPrec = false;
                    }
                    if($flagCompPrec && $flagPalPrec)
                    {
                        $numero = 1;
                        foreach($tabExercices[$i] as $ex){
                            $idEx = $ex->idExercice;
                            $note = Exercices::getNoteUtilisateurByIdExercice($dbh,$idEx,$idUser);
                            Exercices::boutonExercice($note,$ex->nomExercice,$numero,$idEx,true);
                            echo "<p></p>";
                            $numero = $numero + 1;
                            }
                    }

                    echo <<<CHAINE_DE_FIN
                            </div>
                        </div>
                    </div>
CHAINE_DE_FIN;
                }
                echo <<<CHAINE_DE_FIN
                </div>
CHAINE_DE_FIN;
            }
        }
    }
?>