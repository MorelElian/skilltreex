<?php
function affiche(){
$dbh = Database::connect();
$tabCompetences = Competences::getAllCompetences($dbh);
$tabLienCompetences = Competences::getAllLienCompetences($dbh);
$listCouleur =  CompetencesUtilisateur::returnListCouleur($dbh,$_SESSION["idUtilisateur"]);
$tabConcours = ["Polytechnique","Mines","Centrale","CCP"] ;
echo <<<a
  <div class='row' style="text-align:center; margin-top:30px">
a;
foreach($tabConcours as $concours)
{
  echo <<<a
    <div class='col-sm-3 d-grid gap-2'>
      <input class ="btn btn-dark" style="margin-left: 10px; margin-right: 10px;" type = "button" value = "$concours" id = "$concours"/>
    </div>
a;
}
echo <<<a
</div>
<script type = "module">
import * as d3 from "https://cdn.skypack.dev/d3@7";

const div = d3.selectAll("div");
var chart;
// Copyright 2021 Observable, Inc.
// Released under the ISC license.
// https://observablehq.com/@d3/force-directed-graph

function ForceGraph({
nodes, // an iterable of node objects (typically [{id}, …])
links // an iterable of link objects (typically [{source, target}, …])
}, {
nodeId = d => d.id, // given d in nodes, returns a unique identifier (string)
nodeGroup, // given d in nodes, returns an (ordinal) value for color
nodeGroups, // an array of ordinal values representing the node groups
nodeTitle, // given d in nodes, a title string
nodeFill = "currentColor", // node stroke fill (if not using a group color encoding)
nodeStroke = "#fff", // node stroke color
nodeStrokeWidth = 1, // node stroke width, in pixels
nodeStrokeOpacity = 0.4, // node stroke opacity
nodeRadius = 25, // node radius, in pixels
nodeStrength,
linkSource = ({source}) => source, // given d in links, returns a node identifier string
linkTarget = ({target}) => target, // given d in links, returns a node identifier string
linkStroke = "#999", // link stroke color
linkStrokeOpacity = 0.6, // link stroke opacity
linkStrokeWidth = 10, // given d in links, returns a stroke width in pixels
linkStrokeLinecap = "round", // link stroke linecap
linkStrength,
colors = d3.schemeTableau10, // an array of color strings, for the node groups
width = 640, // outer width, in pixels
height = 400, // outer height, in pixels
invalidation // when this promise resolves, stop the simulation
} = {}) {
// Compute values.
const N = d3.map(nodes, nodeId).map(intern);
const CX = d3.map(nodes,d => d.x1);
const CY = d3.map(nodes, d => d.y1);
const COUL = d3.map(nodes, d =>d.couleur);
const LS = d3.map(links, linkSource).map(intern);
const LT = d3.map(links, linkTarget).map(intern);
const X1 = d3.map(links,d => d.x1);
const Y1 = d3.map(links,d => d.y1);
const X2 = d3.map(links,d => d.x2);
const Y2 = d3.map(links,d => d.y2);
const NC = d3.map(nodes, d => d.numCompetence);
if (nodeTitle === undefined) nodeTitle = (_, i) => N[i];
const T = nodeTitle == null ? null : d3.map(nodes, nodeTitle);
const G = nodeGroup == null ? null : d3.map(nodes, nodeGroup).map(intern);
const W = typeof linkStrokeWidth !== "function" ? null : d3.map(links, linkStrokeWidth);
const L = typeof linkStroke !== "function" ? null : d3.map(links, linkStroke);


// Replace the input nodes and links with mutable objects for the simulation.
nodes = d3.map(nodes, (_, i) => ({id: N[i]}));
links = d3.map(links, (_, i) => ({source: LS[i], target: LT[i]}));

// Compute default domains.
if (G && nodeGroups === undefined) nodeGroups = d3.sort(G);

// Construct the scales.
const color = nodeGroup == null ? null : d3.scaleOrdinal(nodeGroups, colors);

// Construct the forces.
const forceNode = d3.forceManyBody();
const forceLink = d3.forceLink(links).id(({index: i}) => N[i]);
if (nodeStrength !== undefined) forceNode.strength(nodeStrength);
if (linkStrength !== undefined) forceLink.strength(linkStrength);

const simulation = d3.forceSimulation(nodes).force("link", forceLink);

const svg = d3.create("svg")
    .attr("width", width)
    .attr("height", height)
    .attr("viewBox", [-width / 2, -height / 2, width, height])
    .attr("style", "max-width: 100%; height: auto; height: intrinsic;");

const link = svg.append("g")
    .attr("stroke", typeof linkStroke !== "function" ? linkStroke : null)
    .attr("stroke-opacity", linkStrokeOpacity)
    .attr("stroke-width", 0.5)
    .attr("stroke-linecap", "round")
  .selectAll("line")
  .data(links)
  .join("line");

const node = svg.append("g")
    .attr("fill", nodeFill)
    .attr("stroke", nodeStroke)
    .attr("stroke-opacity", nodeStrokeOpacity)
    .attr("stroke-width", nodeStrokeWidth)
  .selectAll("circle")
  .data(nodes)
  .join("circle")
    .attr("r", nodeRadius)
    .attr("class", "aaa");

  const text = svg.append("g").attr("fill","black").selectAll("a").data(nodes).join("a")
    .attr("href",({index: i}) => "index.php?page=competence&id=" + N[i] + "'")
    .attr("style","text-decoration:none")
    .append("text")
    .attr("x",({index: i}) => CX[i]-12).attr("y",({index: i}) => CY[i]+5)
    .attr("font-size",14)
    .attr("font-family","Arial")
    .text(({index: i}) => NC[i]);

const nodeLegende = svg.append("g");
//var color = ["#c50111","#fae100","#90c90c","#319203"];
nodeLegende.append("circle").attr("r",nodeRadius-3).attr("fill","#FFFFFF")
        .attr("stroke-width", 8)
        .attr("stroke","#838383")
        .attr("cx",-700).attr("cy",-300);
nodeLegende.append("text").attr("x",-670).attr("y",-300).text("Aucun Palier débloqué").attr("font-size","15px");        
nodeLegende.append("circle").attr("r",nodeRadius-3).attr("fill","#FFFFFF")
        .attr("stroke-width", 8)
        .attr("stroke","#c50111")
        .attr("cx",-700).attr("cy",-240);
nodeLegende.append("text").attr("x",-670).attr("y",-240).text("Palier 0").attr("font-size","15px");  
nodeLegende.append("circle").attr("r",nodeRadius-3).attr("fill","#FFFFFF")
        .attr("stroke-width", 8)
        .attr("stroke","#fae100")
        .attr("cx",-700).attr("cy",-180);
nodeLegende.append("text").attr("x",-670).attr("y",-180).text("Palier 1").attr("font-size","15px");  
nodeLegende.append("circle").attr("r",nodeRadius-3).attr("fill","#FFFFFF")
        .attr("stroke-width", 8)
        .attr("stroke","#90c90c")
        .attr("cx",-700).attr("cy",-120);
nodeLegende.append("text").attr("x",-670).attr("y",-120).text("Palier 2").attr("font-size","15px");  
nodeLegende.append("circle").attr("r",nodeRadius-3).attr("fill","#FFFFFF")
        .attr("stroke-width", 8)
        .attr("stroke","#319203")
        .attr("cx",-700).attr("cy",-60);
nodeLegende.append("text").attr("x",-670).attr("y",-60).text("Palier 3").attr("font-size","15px");  

  const legende = svg.append("g");
  legende.append("circle").attr("r",nodeRadius-15).attr("fill","#4e79a7").attr("cx",400).attr("cy",-300);
  legende.append("text").attr("x",420).attr("y",-297).text("Raisonnement et vocabulaire ensembliste").attr("font-size","12px");

  legende.append("circle").attr("r",nodeRadius-15).attr("fill","#e15759").attr("cx",400).attr("cy",-270);
  legende.append("text").attr("x",420).attr("y",-267).text("Calcul matriciel").attr("font-size","12px");

  legende.append("circle").attr("r",nodeRadius-15).attr("fill","#f28e2c").attr("cx",400).attr("cy",-240);
  legende.append("text").attr("x",420).attr("y",-237).text("Systèmes linéaires").attr("font-size","12px");

  legende.append("circle").attr("r",nodeRadius-15).attr("fill","#76b7b2").attr("cx",400).attr("cy",-210);
  legende.append("text").attr("x",420).attr("y",-207).text("Polynômes").attr("font-size","12px");

  legende.append("circle").attr("r",nodeRadius-15).attr("fill","#59a14f").attr("cx",400).attr("cy",-180);
  legende.append("text").attr("x",420).attr("y",-177).text("Espaces vectoriels").attr("font-size","12px");

  legende.append("circle").attr("r",nodeRadius-15).attr("fill","#edc949").attr("cx",400).attr("cy",-150);
  legende.append("text").attr("x",420).attr("y",-147).text("Espace vectoriels de dimension finie").attr("font-size","12px");

  legende.append("circle").attr("r",nodeRadius-15).attr("fill","#af7aa1").attr("cx",400).attr("cy",-120);
  legende.append("text").attr("x",420).attr("y",-117).text("Applications linéaires").attr("font-size","12px");

  legende.append("circle").attr("r",nodeRadius-15).attr("fill","#ff9da7").attr("cx",400).attr("cy",-90);
  legende.append("text").attr("x",420).attr("y",-87).text("Matrice").attr("font-size","12px");

  legende.append("circle").attr("r",nodeRadius-15).attr("fill","#9c755f").attr("cx",400).attr("cy",-60);
  legende.append("text").attr("x",420).attr("y",-57).text("Déterminant").attr("font-size","12px");
if (W) link.attr("stroke-width", ({index: i}) => 5 );
link.attr("x1",({index: i}) => X1[i]);
link.attr("y1",({index: i}) => Y1[i]);
link.attr("x2",({index: i}) => X2[i]);
link.attr("y2",({index: i}) => Y2[i]);
link.attr("stroke-linecap","round");
link.attr("stroke-width", linkStrokeWidth)
console.log(link);
if (L) link.attr("stroke", ({index: i}) => L[i]);
if (G) node.attr("fill", ({index: i}) => color(G[i]));
if (T) node.append("title").text(({index: i}) => T[i]);
node.attr("opacity",1);
node.attr("class",({index: i}) => T[i]); 
node.attr("cx",({index: i}) => CX[i]);
node.attr("cy", ({index: i}) => CY[i])
node.attr("opacity", 1);
node.attr("onclick",({index: i}) => "location.href ='index.php?page=competence&id=" + N[i] + "'");
node.attr("stroke",({index: i}) => COUL[i]);
node.attr("stroke-width",10);
node.attr("stroke-opacity",1);
node.attr("id",({index: i}) => NC[i]);

if (invalidation != null) invalidation.then(() => simulation.stop());

function intern(value) {
  return value !== null && typeof value === "object" ? value.valueOf() : value;
}



return Object.assign(svg.node(), {scales: {color}});
}
chart = ForceGraph({nodes : [
a;
foreach($tabCompetences as $competence) { 
  echo '{ id :'.$competence->idCompetence.', group :'.$competence->idChapitre.', title : "'.$competence->nom.'", x1 :'.$competence->x1.', y1 : '.$competence->y1.', numCompetence : "'.$competence->numeroCompetence.'", couleur : "'.$listCouleur[$competence->idCompetence].'"},';
}
echo '{id :"a",x1:1000}], links : [';
foreach($tabLienCompetences as $lienCompetences) { 
  echo '{source : '.$lienCompetences->idCompetencePere.',target :'.$lienCompetences->idCompetenceFils.' ,x1:'.Competences::getCompetenceById($dbh,$lienCompetences->idCompetencePere)->x1.',y1:'.Competences::getCompetenceById($dbh,$lienCompetences->idCompetencePere)->y1.',x2:'.Competences::getCompetenceById($dbh,$lienCompetences->idCompetenceFils)->x1.',y2:'.Competences::getCompetenceById($dbh,$lienCompetences->idCompetenceFils)->y1.'},';
} 
echo '{source :"a" ,target : "a"}]}, {
  nodeId: d => d.id,
  nodeGroup: d=> d.group,
  nodeTitle: d => d.title,
  //nodeCX : d=> d.id,
  //nodeCY : d=> d.id,
  width : 1500,
  height: 700,
  invalidation : null // a promise to stop the simulation when the cell is re-run
});
console.log(chart);
document.body.appendChild(chart);

</script>

<script>
centrale = document.getElementById("centrale");'
?>
<?php

foreach($tabConcours as $concours)
{
    echo $concours.' = document.getElementById("'.$concours.'");';
    $listCouleurConcours = ConcoursCompetences::returnListCouleurConcours($dbh,$concours);
    echo $concours.'.onmouseover = function() {
      ';
      foreach($tabCompetences as $competence)
      {
        echo'var a'.$competence->numeroCompetence.' = document.getElementById("'.$competence->numeroCompetence.'");'
        .'a'.$competence->numeroCompetence.'.style.stroke ="'.$listCouleurConcours[$competence->idCompetence].'";';
      }
    echo'};';
    echo $concours.'.onmouseout = function()
    {';
      foreach($tabCompetences as $competence)
      {
        echo'var a'.$competence->numeroCompetence.' = document.getElementById("'.$competence->numeroCompetence.'");'
        .'a'.$competence->numeroCompetence.'.style.stroke ="'.$listCouleur[$competence->idCompetence].'";';
      }
    echo'
    };';
}
echo '
</script>';

#var_dump(CompetencesUtilisateur::returnListOpacity($dbh,$_SESSION["idUtilisateur"]));
}
?>


