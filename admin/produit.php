<!-- PARTIE TRAITEMENT -->

<?php require_once '../inc/header.inc.php'; 


if(!userIsAdmin()){
    header('location:../connexion.php');
    exit();
}

if($_POST)
{   
    
    foreach($_POST as $key => $value)
    {
        $_POST[$key] = htmlspecialchars(addslashes($value));
    }
    if(!empty($_FILES['photo']))
    {
        $nom_img = time() . '' . $_POST['reference'] . '' . $_FILES['photo']['name'];
        
        $img_doc = RACINE . "photo/$nom_img";
        $img_bdd = URL . "photo/$nom_img";

        if($_FILES['photo']['size'] <= 8000000)
        {
            $data = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            

            $tab = ['jpg', 'png', 'jpeg', 'gif', 'JPG', 'PNG', 'JPEG', 'GIF', 'Jpg', 'Png', 'Jpeg', 'Gif'];

            if(in_array($data, $tab))
            {
                move_uploaded_file($_FILES['photo']['tmp_name'], $img_doc);
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
        $rep= $pdo->query("INSERT INTO produit (reference, categorie, titre, description, couleur, taille, public, photo, prix, stock) VALUES ('$_POST[reference]', '$_POST[categorie]', '$_POST[titre]', '$_POST[description]', '$_POST[couleur]', '$_POST[taille]', '$_POST[public]', '$img_bdd', '$_POST[prix]', '$_POST[stock]')");

    }
    
    $rep= $pdo->query("INSERT INTO produit (reference, categorie, titre, description, couleur, taille, public, photo, prix, stock) VALUES ('$_POST[reference]', '$_POST[categorie]', '$_POST[titre]', '$_POST[description]', '$_POST[couleur]', '$_POST[taille]', '$_POST[public]', '$img_bdd', '$_POST[prix]', '$_POST[stock]')");
}



if(isset($_GET['action']) && $_GET['action'] == 'suppression')
{
    $pdo->query("DELETE FROM produit WHERE id_produit = '$_GET[id_produit]'");
    header ('location:produit.php');
    $content .= '<div class="alert alert-success" role="alert">
    Le produit a bien été supprimé
    </div>';
}


$res = $pdo->query("SELECT * FROM produit");
echo '<h1 class="text-center">' . 'Vous avez ' . $res->rowCount() . ' produits en ligne' . '</h1>';
echo '<div class="container">';
echo '<div class="row justify-content-center">';
echo '<div class="col-10">';
echo "<table  border=\'2\'><tr>";

for($i = 0; $i < $res->columnCount(); $i++)
{
    $colonne = $res->getColumnMeta($i);
    echo '<th class="text-center">'.$colonne['name'].'</th>';
}

echo "<th>Update</th>";
echo "<th>Delete</th>";
echo '</tr>';

while($ligne = $res->fetch(PDO::FETCH_ASSOC))
{
    echo '<tr>';
        foreach($ligne as $key=>$info) {
            if($key == 'photo')
            {
                echo "<td><img src='$info' width='100px'></td>";
            } else {
                echo "<td>$info</td>";
            }
        }
    echo '<td><a href="?action=modification&id_produit='.$ligne['id_produit'].'">Update<i class="fas fa-edit"></i></a></td>';
    echo '<td><a href="?action=suppression&id_produit='.$ligne['id_produit'].'">Delete<i class="fas fa-trash-alt"></i></a></td>';

}

echo '</table>';
echo '</div>';
echo '</div>';
echo '</div>';

// s'il y a une action dans l'url et que cette action = modification alors je fais une requête pour modifierr le produit

if (isset($_GET['action']) && $_GET['action'] == 'modification') {

    $res = $pdo->query("SELECT *
                    FROM produit 
                    WHERE id_produit = '$_GET[id_produit]'");

    $produit_actuel = $res->fetch(PDO::FETCH_ASSOC);
}

// Utiliser les conditions ternaire pour pré-remplir les champs 

// si l'id produit_actuel existe alors alors je le récupère sinon je mets rien dans la
$id_produit = (isset($produit_actuel['id_produit'])) ? $produit_actuel['id_produit'] : '';
$reference = (isset($produit_actuel['reference'])) ? $produit_actuel['reference'] : '';
$categorie = (isset($produit_actuel['categorie'])) ? $produit_actuel['categorie'] : '';
$titre = (isset($produit_actuel['titre'])) ? $produit_actuel['titre'] : '';
$description = (isset($produit_actuel['description'])) ? $produit_actuel['description'] : '';
$couleur = (isset($produit_actuel['couleur'])) ? $produit_actuel['couleur'] : '';
$taille = (isset($produit_actuel['taille'])) ? $produit_actuel['taille'] : '';
$public = (isset($produit_actuel['public'])) ? $produit_actuel['public'] : '';
$photo = (isset($produit_actuel['photo'])) ? $produit_actuel['photo'] : '';
$prix = (isset($produit_actuel['prix'])) ? $produit_actuel['prix'] : '';
$stock = (isset($produit_actuel['stock'])) ? $produit_actuel['stock'] : '';


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