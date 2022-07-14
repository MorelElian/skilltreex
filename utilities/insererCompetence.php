<?php
require("../classes/Competences.php");
require("../classes/Database.php");
$dbh = Database::connect();
if(isset($_POST["nom"]))
{
   Competences::insererCompetence($dbh,$_POST["nom"],$_POST["numeroCompetence"],(int)$_POST["idChapitre"],$_POST["descriptif"]);
   var_dump($_POST);
}
?>
<body>
    <h1> Insertion des competences en db </h1>
    <form action = "insererCompetence.php" method = "POST" >
    <input type = "text" name = "numeroCompetence" placeholder = "numeroComp">
    <input type = "text" name = "nom" placeholder = "nom">
    <input type = "text" name = "idChapitre" placeholder = "chapitre">
    <input type = "text" name = "descriptif" placeholder = "descriptif">
    <button type = "submit"> envoyer </button>
</form>
</body>
