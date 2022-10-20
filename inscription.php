<!-- PARTIE TRAITEMENT -->
<?php

require_once './inc/init.php';


$error = '';

if(!empty($_POST))
{
    foreach($_POST as $key => $valeur)
    {
        $_POST[$key] = htmlspecialchars(addslashes($valeur));
    }
    $pseudo = $_POST['pseudo'];
    $mdp = $_POST['mdp'];
    $dispo = $pdo->query("SELECT * FROM membre WHERE pseudo ='$pseudo'");
    $matchesPseudo = '#^[a-zA-Z0-9._-]+$#';
    $matchesMdp = '#^[a-zA-Z0-9._-!?@#]+$#';

    // Vérification de la longueur du pseudo
    // strlen() permet d'avoir la longueur d'une chaine de caractères
    if(strlen($pseudo) < 3 || strlen($pseudo) > 20)
    {
        $error .='<div class="alert alert-danger" role="alert">
        Le pseudo doit être entre 3 et 20 caractères
        </div>';
    };

    // Vérfication des caractères des pseudos
    // preg_match() permet de vérifier une correspondance avec une expression régulières (Regex)
    if(!preg_match($matchesPseudo, $pseudo))
    {
        $error .='<div class="alert alert-danger" role="alert">
        Le pseudo contient des caractères non autorisés
        </div>';
    };

    // Vérification de la disponibilité du pseudo
    // En utilisant rowCount() afficher un message à l'user si le pseudo existe
    if($dispo->rowCount() >=1){
        $error .='<div class="alert alert-danger" role="alert">
        Ce pseudo existe déjà
        </div>';
    }

    // Hasher le mdp en utilisant password_hash()
    $mdp = password_hash($mdp, PASSWORD_DEFAULT);

    // Insérer l'user dans la BDD
    if(empty($error))
    {
        $pdo->query("INSERT INTO membre(pseudo, mdp, nom, prenom, email, civilite, ville, code_postal, adresse) VALUES('$pseudo','$mdp','$_POST[nom]','$_POST[prenom]','$_POST[email]','$_POST[civilite]','$_POST[ville]','$_POST[postal]','$_POST[adresse]')");

        $content .='<div class="alert alert-success" role="alert">
        L\'utilisateur a bien été enregistré :)
        </div>';
    }

    // Longueur du MDP
    if(strlen($mdp) < 6 || strlen($mdp) > 20)
    {
        $error .='<div class="alert alert-danger" role="alert">
        Le mot de passe doit être entre 6 et 20 caractères
        </div>';
    };
 
    // Matches MDP
    if(!preg_match($matchesMdp, $mdp))
    {
        $error .='<div class="alert alert-danger" role="alert">
        Le mot de passe doit contenir au minimum un caractère spécial.
        </div>';
    };



    $content .=$error;
};


 

    


?>
<!-- PARTIE AFFICHAGE -->
<?php
require_once './inc/header.inc.php';

?>
<h1 class="text-center">Inscription</h1>

<form action="" method="POST">
    <div class="container">
    <?= $content; ?>
        <label for="pseudo" class="form-label">Pseudo</label>
        <input type="text" class="form-control" name="pseudo" id="pseudo">

        <label for="mdp" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" name="mdp" id="mdp">

        <label for="prenom" class="form-label">Prénom</label>
        <input type="text" class="form-control" name="prenom" id="prenom">

        <label for="nom" class="form-label">Nom</label>
        <input type="text" class="form-control" name="nom" id="nom">

        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" name="email" id="email">

        <input type="radio" name="civilite" id="civilite" value="m" checked>
        Homme -- Femme
        <input type="radio" name="civilite" id="civilite" value="f" checked><br>

        <label for="ville" class="form-label">Ville</label>
        <input type="text" class="form-control" name="ville" id="ville">

        <label for="postal" class="form-label">Code Postal</label>
        <input type="text" class="form-control" name="postal" id="postal">

        <label for="adresse" class="form-label">Adresse</label>
        <input type="text" class="form-control" name="adresse" id="adresse">

        <input type="submit" class="btn btn-outline-primary btn-lg mt-2" value="S'inscrire">
    </div>

</form>

<?php
require_once './inc/footer.inc.php';
?>