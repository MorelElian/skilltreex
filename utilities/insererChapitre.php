<?php
require("classes/Chapitres.php");
require("classes/Database.php");
$dbh = Database::connect();
if(isset($_POST["nomChapitre"])){
   Chapitres::insererChapitre($dbh,$_POST["nomChapitre"],$_POST["domaine"]);
   var_dump($_POST);
}
?>
<body>
    <h1> Insertion des chapitres en DB </h1>
    <form action = "insererChapitre.php" method = "POST" >
    <input type = "text" name = "nomChapitre" placeholder = "nomChapitre">
    <input type = "text" name = "domaine" placeholder = "domaine">
    <button type = "submit"> envoyer </button>
</form>
</body>
