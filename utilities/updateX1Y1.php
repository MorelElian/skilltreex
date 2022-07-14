<?php
require("../classes/Competences.php");
require("../classes/Database.php");
$dbh = Database::connect();
if(isset($_POST["x1"]))
{
   Competences::updateX1Y1($dbh,(int)$_POST["x1"],(int)$_POST["y1"],$_POST["numeroCompetence"]);
   var_dump($_POST);
}
?>
<body>
    <h1> Position compétences en db </h1>
    <form action = "updateX1Y1.php" method = "POST" >
    <input type = "text" required name = "x1" placeholder = "x1">
    <input type = "text" required name = "y1" placeholder = "y1">
    <input type = "text" required name = "numeroCompetence" placeholder = "numCompetence">
    <button type = "submit"> envoyer </button>
</form>
</body>