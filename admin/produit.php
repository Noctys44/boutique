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

<?php if (isset($_GET['action']) && $_GET['action'] == 'modification') : ?>
    <h4 class="text-center display-4  text-warning">Modification un produit</h4>
<?php else : ?>
    <h4 class="text-center display-4">Ajouter un produit</h4>
<?php endif ?>


<form method="post" action="" enctype="multipart/form-data">
    <!--- Je récupère l'id du produit que je veux modifier dans un input hidden-------->
    <input type="hidden" name="id_produit" value="<?= $id_produit ?>">

    <!----Pour tous les inputs je vais pré-remplir l'attribut value avec le resultat issu de ma condtion ternaire------->
    <label for="reference">Reference</label>
    <input type="text" name="reference" placeholder="reference du produit" id="reference" class="form-control" value="<?= $reference ?>"><br>

    <label for="categorie">Categorie</label>
    <input type="text" name="categorie" placeholder="categorie du produit" id="categorie" class="form-control" value="<?= $categorie ?>"><br>

    <label for="titre">Titre</label>
    <input type="text" name="titre" placeholder="titre du produit" id="titre" class="form-control" value="<?= $titre ?>"><br>

    <label for="description">Description</label>
    <textarea name="description" placeholder="description du produit" id="description" class="form-control"><?= $description ?></textarea><br>

    <label for="couleur">Couleur</label>
    <select name="couleur" placeholder="couleur du produit" id="couleur" class="form-control">
        <!------Si la couleur est == bleu echo bleu etc...---------->
        <option <?php if ($couleur == 'Blanc') echo 'selected'; ?>>Blanc</option>
        <option <?php if ($couleur == 'Noir') echo 'selected'; ?>>Noir</option>
        <option <?php if ($couleur == 'Rouge') echo 'selected'; ?>>Rouge</option>
        <option <?php if ($couleur == 'Bleu') echo 'selected'; ?>>Bleu</option>
        <option <?php if ($couleur == 'Jaune') echo 'selected'; ?>>Jaune</option>
        <option <?php if ($couleur == 'Multicolore') echo 'selected'; ?>>Multicolore</option>
    </select>
    <br>

    <label for="taille">Taille</label>
    <select name="taille" placeholder="taille du produit" id="taille" class="form-control">
        <!------Si la taille est == XS echo bleu etc...---------->
        <option <?php if ($taille == 'XS') echo 'selected'; ?>>XS</option>
        <option <?php if ($taille == 'S') echo 'selected'; ?>>S</option>
        <option <?php if ($taille == 'M') echo 'selected'; ?>>M</option>
        <option <?php if ($taille == 'L') echo 'selected'; ?>>L</option>
        <option <?php if ($taille == 'XL') echo 'selected'; ?>>XL</option>
        <option <?php if ($taille == 'XXL') echo 'selected'; ?>>XXL</option>
        <option <?php if ($taille == 'Autre taille') echo 'selected'; ?>>Autre taille</option>
    </select>
    <br>

    <label for="public">public</label>
    <select name="public" placeholder="public du produit" id="public" class="form-control">
        <option value="m" <?php if ($public == 'm') echo 'selected'; ?>>Homme</option>
        <option value="f" <?php if ($public == 'f') echo 'selected'; ?>>Femme</option>
        <option value="Mixte" <?php if ($public == 'Mixte') echo 'selected'; ?>>Mixte</option>
    </select>
    <br>

    <label for="photo">Photo</label>
    
    <input type="file" name="photo" id="photo" class="form-control" value="<?= $photo ?>">
    <!----Si la photo n'est pas vide (le cas ou le produit a déjà une photo----->
    <?php if (!empty($photo)) : ?>
        <p>Vous pouvez ajouter une nouvelle photo.<br>
            <!----afficher la photo---->
            <img src="<?= $photo ?>" width="50">
        </p><br>

    <?php endif;     ?>
    <input type="hidden" name="photo_actuelle" value="<?= $photo  ?>"><br>

    <br>

    <label for="prix">Prix</label>
    <input type="text" name="prix" placeholder="prix du produit" id="prix" class="form-control" value="<?= $prix ?>"><br>

    <label for="stock">Stock</label>
    <input type="text" name="stock" placeholder="stock du produit" id="stock" class="form-control" value="<?= $stock ?>"><br>



    <div class="text-center mb-5">
        <?php if (isset($_GET['action']) && $_GET['action'] == 'modification') : ?>
            <br><input type="submit" value="Valider la modification" class="btn btn-lg btn-info">
        <?php else : ?>
            <br><input type="submit" value="Ajouter le produit" class="btn btn-lg btn-primary">
        <?php endif ?>
    </div>


</form>


<?php
require_once '../inc/footer.inc.php';
?>