<?php
require("../classes/Connaissances.php");
require("../classes/Competences.php");
require("../classes/Database.php");
$dbh = Database::connect();
if(isset($_POST["concours"]))
{
    ConcoursCompetences::insererConcoursCompetenes($dbh,$_POST["concours"],$_POST["numeroCompetence"],$_POST["palier"]);
    
}
?>
<body>
    <h1> Insertion des connaissances en db </h1>
    <form action = "insererConcoursCompetences.php" method = "POST" >
    <input type="radio" id="centrale" name="concours" value="centrale">
    <label for="centrale">Centrale</label><br>
    <input type="radio" id="polytechnique" name="concours" value="polytechnique">
    <label for="polytechnique">Polytechnique</label><br>
    <input type="radio" id="ccp" name="concours" value="ccp">
    <label for="ccp">ccp</label>
    <input type = "text" name = "numeroCompetence" required placeholder = "numeroCompetence">
    <input type = "text" name = "palier" required placeholder = "palier">
    <button type = "submit"> envoyer </button>
</form>
</body>