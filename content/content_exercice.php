<?php
function affiche()
{
    if (!array_key_exists('id', $_GET)) {
        echo "<p>Aucun identifiant précisé pour l'exercice.</p>";
    } else {
        global $dbh;
        $idEx = $_GET['id'];
        $ex = Exercices::getExerciceByIdExercice($dbh, $idEx);
        if ($ex == false) {
            echo "<p>Aucun exercice n'a cet identifiant.</p>";
        } else {
            $idCompetence = $ex->idCompetence;
            if (!array_key_exists('notation', $_GET)) {
                $comp = Competences::getCompetenceById($dbh, $idCompetence);
                $numero = $_GET["numero"];
                $nomFichier = "$comp->numeroCompetence" . "_Palier$ex->numeroPalier" . "_$numero";
                $filePath = "Exercices/$comp->idChapitre/$comp->numeroCompetence/$nomFichier.png";

                echo <<<CHAINE_DE_FIN
            <div class="row">
                <div class='col-sm-1' style="text-align:center">
                </div>
                <div class='col-sm-10' style="text-align:center">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                    Exercice (cliquer pour visualiser l'exercice)
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <div class="row">
CHAINE_DE_FIN;
                if (file_exists($filePath)) {
                    echo "<img class='fit-picture' src=$filePath>";
                } else {
                    echo "Pas d'exercice pour ce palier, vous pouvez directement vous attribuer la note A.";
                }
                echo <<<CHAINE_DE_FIN
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class='col-sm-4' style="text-align:center">
                </div>
                <div class='col-sm-4' style="text-align:center">
                    <a href='/index.php?page=exercice&id=$idEx&numero=$numero&notation=true' class='btn btn-outline-success active' role='button' >Terminer</a>
                    <a href='/index.php?page=competence&id=$idCompetence' class='btn btn-outline-danger active' role='button' >Retour à la page compétence</a>
                </div>
            </div>
            <div class="row" style="margin-top:50px">
            </div>
CHAINE_DE_FIN;
            } else {
                $note = Exercices::getNoteUtilisateurByIdExercice($dbh, $idEx, $_SESSION['idUtilisateur']);
                if ($note == "F") {
                    $note = "Non noté";
                }
                $comp = Competences::getCompetenceById($dbh, $idCompetence);
                $numero = $_GET["numero"];
                $nomFichier = "$comp->numeroCompetence" . "_Palier$ex->numeroPalier" . "_$numero" . "_correction";
                $filePath = "Exercices/$comp->idChapitre/$comp->numeroCompetence/$nomFichier.png";
                echo <<<CHAINE_DE_FIN
        <div class="row" style="text-align:center">
            <h1>Notation de l'exercice</h1>
            <h3>Votre dernière note était : $note</h3>
        </div>
        <div class="row">
                <div class='col-sm-1' style="text-align:center">
                </div>
                <div class='col-sm-10' style="text-align:center">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                    Correction (cliquer pour visualiser la correction)
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <div class="row">
CHAINE_DE_FIN;
                if (file_exists($filePath)) {
                    echo "<img class='fit-picture' src=$filePath>";
                } else {
                    echo "Il n'y a pas d'exercice ou seulement des notions de cours à connaître. Dans le 2ème cas, évaluez votre degré de connaissance.";
                }


                echo <<<CHAINE_DE_FIN
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <div class="row" style="text-align:center">
            <h3>Quelle note estimez-vous avoir obtenu pour cet exercice ?</h3>
            <form action="/index.php?page=competence&id=$idCompetence&todo=updateNote&idEx=$idEx" method=post>
                <select required name="note" class="form-select" aria-label="Default select example">
                    <option selected></option>
CHAINE_DE_FIN;
                if ($note >= "A") {
                    echo '<option value="A">A [16, 20]</option>';
                }
                if ($note >= "B") {
                    echo '<option value="B">B [12, 16]</option>';
                }
                if ($note >= "C") {
                    echo '<option value="C">C [8, 12]</option>';
                }
                if ($note >= "D") {
                    echo '<option value="D">D [4, 8]</option>';
                }
                if ($note >= "E") {
                    echo '<option value="E">E [0, 4]</option>';
                }
                echo <<<CHAINE_DE_FIN
                </select>
    
                <input type=submit class='btn btn-outline-success active' value="Valider">
            </form>
        </div>
        <div class="row" style="margin-top:50px">
        </div>
CHAINE_DE_FIN;
            }
        }
    }
}
