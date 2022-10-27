<!-- PARTIE TRAITEMENT -->

<?php 
require_once './inc/header.inc.php';


// Je fais une req pour récupérer mes catégories . DISTINCT Permet d'éliminer les doublons
$req = $pdo->query("SELECT DISTINCT categorie FROM produit");

$content .= '<div class="container">';

$content .= '<div class="row">';
$content .= '<div class="col-md-2">';
$content .= '<h3 class="lead">Nos catégories</h3>';

while($categorie = $req->fetch(PDO::FETCH_ASSOC)){ // Je fetch sur le résultat de ma req pour tout avoir
  $content .= "<ul class=\"list-group\">";
  $content .= "<li class=\"list-group-item mt-2\">";
  $content .= "<a href=\"boutique.php?categorie=$categorie[categorie]\">$categorie[categorie]</a>"; // Je passe dans l'url la catégorie du produit
  $content .= "</li>";
  $content .= "</ul>";

}
$content .= '</div>';


$content .= '<div class="col-md-8 md-offset-1">';


if(isset($_GET['categorie'])){
  $produits = $pdo->query("SELECT * FROM produit WHERE categorie = '$_GET[categorie]'");

  while($produit = $produits->fetch(PDO::FETCH_ASSOC)){

    // J'utilise substr() afin de réduire la taille de la chaine de caractère qui contient le détail
    $detail = substr($produit['description'],0.150);

    $content .= '<div class="col-md-6 col-sm-6 col-lg-6">';
    $content .= '<div class="card" style="width: 18rem;">';
    $content .= "<img class=\"card-img-top\" src=\"$produit[photo]\">";
    $content .= '<div class="card-body">';
    $content .= "<h6 class=\"card-subtitle mb-2 text-muted\">$produit[categorie]</h6>";
    $content .= "<h5 class=\"card-title\">$produit[titre]</h5>";
    $content .= "<p class=\"card-text\">$detail ...<a href=\"fiche-produit.php?id_produit=$produit[id_produit]\" class=\"text-decoration-none\">Lire la suite</a></p>";
    $content .= "<p><a href=\"\" class=\"card-link fw-bold text-decoration-none text-dark\">$produit[prix] €</p></a>";
    $content .= "<a href=\"fiche-produit.php?id_produit=$produit[id_produit]\" class=\"btn btn-dark\">Voir ce produit</a>";
    $content .= '</div>';
    $content .= '</div>';
    $content .= '</div>';

//  A NE PAS REPRODUIRE
    $content .= '<div class="col-md-6 col-sm-6 col-lg-6">';


  }


}
$content .= '</div>'; 


$content .= '</div>'; // Fermeture de la div container




?>




<!-- PARTIE AFFICHAGE -->


<h1 class="text-center">Boutique</h1>

<?= $content ?>

<?php
require_once './inc/footer.inc.php';
?>