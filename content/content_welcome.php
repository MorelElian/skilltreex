<?php
    function affiche(){
        echo<<<CHAINE_DE_FIN
        <div class="row image">
            <div class="row" style="text-align:center;margin-top:50px;font-size:100px">
                <h1 class ="PT" style="font-size:150px">Tree<span class="dancing" style="font-size:250px;margin-left:-20px;margin-bottom:-100px">X</span></h1>
            </div>
            
CHAINE_DE_FIN;
        if($_SESSION["loggedIn"]){
            echo<<<CHAINE_DE_FIN
        <div class="row" style="text-align:center">
            <div class='col-sm-4'></div>
            <div class='col-sm-4'>
                <a style="font-size:20px;margin-left:50px" href='?page=testArbre' class='btn btn-outline-danger active text-white' role='button'>Accéder à mon arbre de compétence</a>
                <a style="font-size:20px;margin-left:50px; margin-top:50px" href='https://docs.google.com/forms/d/e/1FAIpQLSe0GUlTHOOduaAvlBvV0zEVrkc2hlMcDC00EsK_Irv9dHEp8w/viewform?usp=sf_link' class='btn btn-outline-warning active text-black' role='button'>Je donne mon avis sur le site</a>
            </div>
        </div>
CHAINE_DE_FIN;
        }
        echo<<<CHAINE_DE_FIN
            <div class="row bg-dark" style="text-align:center;margin-top:70px;padding-bottom:60px;color:white">
                <div class='col-sm-4'>
                    
                    <div class="card text-white bg-danger mb-3" style="max-width: 18rem; margin-left: auto;margin-right: auto; margin-top : 30px; border-radius: 30px;margin-top:55px">
                        <div class="card-body">
                            <h5 class="card-title">Arbre de compétence</h5>
                            <p class="card-text">Visualisez l'ensemble des compétences sous forme de noeuds connectés entre eux. Les liens modélisent les prérequis pour débloquer une nouvelle compétence. </p>
                        </div>
                    </div>

                </div>
                
                <div class='col-sm-4'>

                    <div class="card text-black bg-warning mb-3" style="max-width: 18rem; margin-left: auto;margin-right: auto; margin-top : 30px; border-radius: 30px;margin-top:55px">
                        <div class="card-body">
                            <h5 class="card-title">Progression par palier</h5>
                            <p class="card-text text-black">Progressez au sein de l'arbre de compétence en validant les paliers des différents noeuds de l'arbre.</p>
                        </div>
                    </div>
                </div>
                
                <div class='col-sm-4'>

                    <div class="card text-white bg-danger mb-3" style="max-width: 18rem; margin-left: auto;margin-right: auto; margin-top : 30px; border-radius: 30px;margin-top:55px">
                        <div class="card-body">
                            <h5 class="card-title">Attendus des concours</h5>
                            <p class="card-text">Adaptez votre progression en fonction du concours que vous visez. Un système de prévisualisation vous permet de connaître ces attendus pour chaque compétence.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
CHAINE_DE_FIN;
    }
?>
