<?php
require("../classes/Competences.php");
require("../classes/Database.php");
$dbh = Database::connect();
if(isset($_POST["numeroCompetencePere"]))
{
   Competences::insererLienCompetences($dbh,$_POST["numeroCompetencePere"],$_POST["numeroCompetenceFils"]);
   var_dump($_POST);
}
?>
<body>
    <h1> Insertion des  lien de competences en db </h1>
    <form action = "insererLienCompetence.php" method = "POST" >
    <input type = "text" name = "numeroCompetencePere" placeholder = "numeroPere">
    <input type = "text" name = "numeroCompetenceFils" placeholder = "numeroFils">
    <button type = "submit"> envoyer </button>
</form>
</body>