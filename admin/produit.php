<!-- PARTIE TRAITEMENT -->

<?php 

require_once '../inc/header.inc.php';

if(!userIsAdmin()){
    header('location:../index.php/');
    exit();
}

if($_POST){
    if(empty($_POST['photo'])){
        $defaultImage = URL . './img/default.jpg';
        $pdo->query("INSERT INTO produit(reference, categorie, titre, description, couleur, taille, public, photo, prix,stock) VALUES('$_POST[reference]','$_POST[categorie]','$_POST[titre]','$_POST[description]','$_POST[couleur]','$_POST[taille]','$_POST[public]','$defaultImage','$_POST[prix]','$_POST[stock]')");
    } else {
        $updateImage = URL . $_POST['photo'];
        $pdo->query("INSERT INTO produit(reference, categorie, titre, description, couleur, taille, public, photo, prix,stock) VALUES('$_POST[reference]','$_POST[categorie]','$_POST[titre]','$_POST[description]','$_POST[couleur]','$_POST[taille]','$_POST[public]','$updateImage','$_POST[prix]','$_POST[stock]')");

        if (!empty($_FILES['photo'])) 
    {
        $nomImg = time() . '_' . rand() . '_' . $_FILES['photo']['name'];
        $img_bdd = URL . "img/$nomImg"; 
        define("BASE",$_SERVER['DOCUMENT_ROOT'] . '/php/img/'); 
        $img_doc = BASE ."img/$nomImg"; 
    
        if($_FILES['photo']['size'] <= 8000000)
        {
            $info = pathinfo($_FILES['photo']['name']);
            $ext = $info['extension']; 
            $tabExt = ['jpg', 'png', 'jpeg', 'gif', 'JPG', 'PNG', 'JPEG', 'GIF', 'Jpg', 'Png', 'Jpeg', 'Gif'];
    
            if(in_array($ext, $tabExt))
            {
                copy($_FILES['photo']['tmp_name'],$img_doc);
                $pdo->query("INSERT INTO produit(photo) VALUES('$img_bdd')");
            } else {
                echo "Format non autorisé";
            }
    
        } else {
            echo "Vérifier la taille de votre image";
        }
    
    }
    }


    $content .='<div class="alert alert-success" role="alert">
    Le produit a bien été enregistré :)
    </div>';
};


?>




<!-- PARTIE AFFICHAGE -->

<h1 class="text-center">Ajout de produits</h1>

<form action="" method="POST"> 
    <div class="container">
        <?= $content;  ?>
        <label for="reference" class="form-label">Référence</label>
        <input type="text" class="form-control" name="reference" id="reference">

        <label for="categorie" class="form-label">Categorie</label>
        <input type="text" class="form-control" name="categorie" id="categorie">

        <label for="titre" class="form-label">Titre</label>
        <input type="text" class="form-control" name="titre" id="titre">

        <label for="description" class="form-label">Description</label>
        <input type="text" class="form-control" name="description" id="description">

        <label for="couleur" class="form-label">Couleur</label>
        <input type="text" class="form-control" name="couleur" id="couleur">

        <label for="taille" class="form-label">Taille</label>
        <input type="text" class="form-control" name="taille" id="taille">

        <label for="public">Genre</label><br>
        <div class="word-spacing border col-3 text-center">
            <input type="radio" name="public" id="public_m" value="m" checked>Homme
            <input type="radio" name="public" id="public_f" value="f" checked>Femme
            <input type="radio" name="public" id="public_mixte" value="mixte" checked>mixte<br>
        </div>


        <label for="photo" class="form-label">Photo</label>
        <input type="file" class="form-control" name="photo" id="photo">

        <label for="prix" class="form-label">Prix</label>
        <input type="text" class="form-control" name="prix" id="prix">

        <label for="stock" class="form-label">Stock</label>
        <input type="text" class="form-control" name="stock" id="stock">

        <input type="submit" class="btn btn-outline-primary btn-lg mt-2" value="Ajouter">
    </div>

</form>

<?php
require_once '../inc/footer.inc.php';
?>