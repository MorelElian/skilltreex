<?php
session_name("NomDeSessionAModifierSelonVotreGoutfgdgh");
// ne pas mettre d'espace dans le nom de session !
session_start();
if (!isset($_SESSION['initiated'])) {
    session_regenerate_id();
    $_SESSION['initiated'] = true;
}

require("classes/Utilisateurs.php");
require("classes/Database.php");
require("classes/Chapitres.php");
require("classes/Competences.php");
require("classes/Connaissances.php");
require("classes/CompetencesUtilisateur.php");
require("classes/Exercices.php");
require("utilities/utils.php");
require("utilities/logInOut.php");
require("utilities/printForms.php");
require("classes/ConcoursCompetences.php");

$dbh = Database::connect();

if (isset($_GET["page"])) {
    $askedPage = $_GET["page"];
} else {
    $askedPage = 'welcome';
}

if (array_key_exists('todo', $_GET) && $_GET['todo'] == 'login') {
    logIn($dbh);
    if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]) {
        $askedPage = 'welcome';
    }
}
if (array_key_exists('todo', $_GET) && $_GET['todo'] == 'logout') {
    logOut($dbh);
}


$authorized = checkPage($askedPage);
if ($authorized) $pageTitle = getPageTitle($askedPage);
else $pageTitle = "Erreur";
generateHTMLHeader($pageTitle, "feuilleStyle");
echo "<nav id='menu'>";
generateMenu();
echo "</nav>";


echo "<div id='content'>";
if ($authorized) {
    require("content/content_$askedPage.php");
    affiche($askedPage);
} else {
    echo "<p>Désolé, la page demandée n'existe pas ou n'est accessible qu'aux gentlemen.</p>";
}
echo "</div>";


generateHTMLFooter();
