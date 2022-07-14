<?php
require("../classes/Connaissances.php");
require("../classes/Competences.php");
require("../classes/Database.php");
$dbh = Database::connect();
if(isset($_POST["numeroCompetence"]))
{
    Competences::insererDescriptif($dbh,$_POST["numeroCompetence"],$_POST["descriptif"]);
    
}
?>
<body>
    <h1> Insertion descriptif en db </h1>
    <form action = "insererDescriptif.php" method = "POST" >
    <input type = "text" name = "numeroCompetence" required placeholder = "numeroCompetence">
    <input type = "text" name = "descriptif" required placeholder = "descriptif">
    <button type = "submit"> envoyer </button>
</form>
</body>