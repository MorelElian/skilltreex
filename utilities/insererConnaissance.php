<?php
require("../classes/Connaissances.php");
require("../classes/Competences.php");
require("../classes/Database.php");
$dbh = Database::connect();
if(isset($_POST["nomConnaissance"]))
{
    Connaissances::insererConnaissance($dbh,$_POST["numeroCompetence"],$_POST["nomConnaissance"]);
    
}
?>
<body>
    <h1> Insertion des connaissances en db </h1>
    <form action = "insererConnaissance.php" method = "POST" >
    <input type = "text" name = "numeroCompetence" required placeholder = "numeroCompetence">
    <input type = "text" name = "nomConnaissance" required placeholder = "nomConnaissance">
    <button type = "submit"> envoyer </button>
</form>
</body>