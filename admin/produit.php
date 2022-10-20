<!-- PARTIE TRAITEMENT -->

<?php 

require_once '../inc/header.inc.php';

if(!userIsAdmin()){
    header('location:../index.php/');
    exit();
}

if($_POST)
{
    foreach($_POST as $key => $value)
    {
        $_POST[$key] = htmlspecialchars(addslashes($value));
    }
    if(!empty($_POST['photo']))
    {
        $nom_img = time() . '_' . $_POST['reference'] . '_' . $_POST['photo']['name'];
        $img_doc = RACINE . "photo/$nom_img";
        $img_bdd = URL . "photo/$nom_img";

        if($_FILES['photo']['size'] <= 8000000)
        {
            $data = pathinfo($_FILES['photo']['name']);
            $img_ext = $data['extension'];
            $tab = ['jpg', 'png', 'jpeg', 'gif', 'JPG', 'PNG', 'JPEG', 'GIF', 'Jpg', 'Png', 'Jpeg', 'Gif'];
            if(in_array($tab, $img_ext))
            {
                move_uploaded_file($_FILES['photo']['tmp_name'], $img_doc)
            } else {
                $content .='<div class="alert alert-danger" role="alert">
                Format non autorisé 
                </div>';
           } 
        } else {
            $content .='<div class="alert alert-danger" role="alert">
            Vérifier la taille de votre image
            </div>';
        }
}



if($_POST){
    if(empty($_POST['photo'])){
        $defaultImage = URL . './img/default.jpg';
        $pdo->query("INSERT INTO produit(reference, categorie, titre, description, couleur, taille, public, photo, prix,stock) VALUES('$_POST[reference]','$_POST[categorie]','$_POST[titre]','$_POST[description]','$_POST[couleur]','$_POST[taille]','$_POST[public]','$defaultImage','$_POST[prix]','$_POST[stock]')");
    } else {
        $updateImage = URL . $_POST['photo'];
        $pdo->query("INSERT INTO produit(reference, categorie, titre, description, couleur, taille, public, photo, prix,stock) VALUES('$_POST[reference]','$_POST[categorie]','$_POST[titre]','$_POST[description]','$_POST[couleur]','$_POST[taille]','$_POST[public]','$updateImage','$_POST[prix]','$_POST[stock]')");

    //     if (!empty($_FILES['photo'])) 
    // {
    //     $nomImg = time() . '_' . rand() . '_' . $_FILES['photo']['name'];
    //     $img_bdd = URL . "img/$nomImg"; 
    //     define("BASE",$_SERVER['DOCUMENT_ROOT'] . '/php/img/'); 
    //     $img_doc = BASE ."img/$nomImg"; 
    
    //     if($_FILES['photo']['size'] <= 8000000)
    //     {
    //         $info = pathinfo($_FILES['photo']['name']);
    //         $ext = $info['extension']; 
    //         $tabExt = ['jpg', 'png', 'jpeg', 'gif', 'JPG', 'PNG', 'JPEG', 'GIF', 'Jpg', 'Png', 'Jpeg', 'Gif'];
    
    //         if(in_array($ext, $tabExt))
    //         {
    //             copy($_FILES['photo']['tmp_name'],$img_doc);
    //             $pdo->query("INSERT INTO produit(photo) VALUES('$img_bdd')");
    //         } else {
    //             echo "Format non autorisé";
    //         }
    
    //     } else {
    //         echo "Vérifier la taille de votre image";
    //     }
    
    // }
    // }


    $content .='<div class="alert alert-success" role="alert">
    Le produit a bien été enregistré :)
    </div>';
};


?>




<!-- PARTIE AFFICHAGE -->

<h1 class="text-center">Ajout de produits</h1>

<form action="" method="POST" enctype="multipart/form-data"> 
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
        <select class="form-select" name="couleur">
            <option>Noir</option>
            <option>Blanc</option>
            <option>Bleu</option>
            <option>Rouge</option>
            <option>Vert</option>
            <option>Jaune</option>
            <option>Orange</option>
        </select>

        <label for="taille" class="form-label">Taille</label>
        <select class="form-select" name="taille">
            <option>XS</option>
            <option>S</option>
            <option>M</option>
            <option>L</option>
            <option>XL</option>
            <option>XXL</option>
            <option>Autre taille</option>
        </select>

        <label for="public">Genre</label><br>
        <select class="form-select" name="public">
            <option value="m">Homme</option>
            <option value="f">Femme</option>
            <option value="mixte">Mixte</option>
        </select>


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