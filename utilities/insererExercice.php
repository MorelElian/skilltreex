<?php
require("../classes/Exercices.php");
require("../classes/Database.php");
require("../classes/Competences.php");
$dbh = Database::connect();
if(isset($_POST["numeroCompetence"]))
{
   Exercices::insererExercice($dbh,$_POST["numeroCompetence"],(int)$_POST["numeroPalier"],$_POST["numeroExercice"]);
}
?>
<body>
    <h1> Insertion des exercices en db </h1>
    <form action = "insererExercice.php" method = "POST" >
    <input type = "text" name = "numeroCompetence" required placeholder = "numeroCompetence">
    <input type = "text" name = "numeroPalier" required placeholder = "numeroPalier">
    <input type = "text" name = "numeroExercice" required placeholder = "numeroExercice">
    <button type = "submit"> envoyer </button>
</form>
</body>