<!-- PARTIE TRAITEMENT -->
<?php 
require_once './inc/header.inc.php';

// Je vérifie s'il n'y a pas un id_produit dans l'url
if(!isset($_GET['id_produit'])){
    header('location:boutique.php'); // Je renvoi le user vers boutique.php
    exit();
}

if(isset($_GET['id_produit'])){ // S'il y a id dans l'url, je fais une req pour écupérer les data de cet id
    $data = $pdo->query("SELECT * FROM produit WHERE id_produit = '$_GET[id_produit]'");
}

if($data->rowCount() <= 0){ // Si le rowCount() est <= 0 c'est que je n'ai pas de produit qui a cet id
    header('location:index.php');
    exit();
}

$produit = $data->fetch(PDO::FETCH_ASSOC);

$content .= '<div class="container text-center">';
$content .= "<p> Titre :". $produit['titre'] . "</p>";
$content .= "<p> Catégorie :". $produit['categorie'] . "</p>";
$content .= "<p> Référence :". $produit['reference'] . "</p>";
$content .= "<p> Taille :". $produit['taille'] . "</p>";
$content .= "<p> Couleur :". $produit['couleur'] . "</p>";
$content .= "<p> Public :". $produit['public'] . "</p>";
$content .= "<img src=\"$produit[photo]\">";
$content .= "<p> Prix :". $produit['prix'] . "</p>";


if($produit['stock'] > 0){

    $content .= '<form action="panier.php" method=POST>';

    $content .= "<input type=hidden name=\"id_produit\" value=\"$produit[id_produit]\">";
    $content .= "<label for=\"quantite\">Quantité</label>";
    $content .= "<select name=\"quantite\" id=\"quantite\">";
        for($i = 1; $i <= $produit['stock']; $i++){
            $content .= "<option>$i</option>";
        }
    $content .= "</select><br><br>";
    $content .= '<input type="submit" class="btn btn-lg btn-dark mb-5" name="ajout_panier" value="Ajouter au panier">';
    $content .= '</form>';

} else {
    $content .= '<div class="alert alert-danger" role="alert">Le produit est actuellement en rupture</div>';
}

$content .= '</div>';

?>


<!-- PARTIE AFFICHAGE -->
<h2 class="text-center text-muted">Fiche produit</h2>


<?= $content; ?>


<?php
require_once './inc/footer.inc.php';
?>