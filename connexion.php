<!-- PARTIE TRAITEMENT -->


<?php

require_once './inc/init.php';

$error = '';


if(isset($_GET['action']) && $_GET['action'] == 'deconnexion'){
    session_destroy();
    header('location:index.php');
}

if($_POST){
    if(!empty($_POST['pseudo'])) // Si le pseudo n'est pas vide
    {
        // Je fais une requête pour récupérer les infos du pseudo qui ont été envoyé en POST
        $req = $pdo->query("SELECT * FROM membre WHERE pseudo = '$_POST[pseudo]'");

        // Si le rowCount() est >= 1 alors il y a un user qui a ce pseudo
        if($req->rowCount() >= 1)
        {
            $membre = $req->fetch(PDO::FETCH_ASSOC); // Je fetch pour récupérer les infos dans un tableau

            // Je vérifie si le mot de passe envoyé en POST correspond au mdp que j'ai dans mon tableau $membre qui contient toutes les infos du membre
            if(password_verify($_POST['mdp'], $membre['mdp']))
            {
                // Je crée une session qui s'appelle 'membre' pour stocker les infos de l'user
                $_SESSION['membre']['id_membre'] = $membre['id_membre'];
                $_SESSION['membre']['pseudo'] = $membre['pseudo'];
                $_SESSION['membre']['nom'] = $membre['nom'];
                $_SESSION['membre']['prenom'] = $membre['prenom'];
                $_SESSION['membre']['email'] = $membre['email'];
                $_SESSION['membre']['civilite'] = $membre['civilite'];
                $_SESSION['membre']['ville'] = $membre['ville'];
                $_SESSION['membre']['code_postal'] = $membre['code_postal'];
                $_SESSION['membre']['adresse'] = $membre['adresse'];
                $_SESSION['membre']['statut'] = $membre['statut'];


                header('location:profil.php');
            } else {
                $content .= '<div class="alert alert-danger" role="alert">
                Le mot de passe est incorrect
                </div>';
            }
        } else {
            $content .= '<div class="alert alert-danger" role="alert">
            Le pseudo est incorrect
            </div>';
        }
    }
}


// Vérifier que le mot de passe corresponde au pseudo
// if(!empty($_POST))
// {
//     $pseudo = $_POST['pseudo'];
//     $mdp = $_POST['mdp'];
//     $req = $pdo->prepare("SELECT * FROM membre WHERE pseudo = :pseudo");
//     $req->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
//     $req->execute();
//     if($req->rowCount() > 0)
//     {
//         $membre = $req->fetch(PDO::FETCH_ASSOC);
//         if(password_verify($mdp, $membre['mdp']))
//         {
//             $_SESSION['membre'] = $membre;
//             header('location:profil.php');
//         } else {
//             $error .='<div class="alert alert-danger" role="alert">
//             Le mot de passe est incorrect
//             </div>';
//         }
//     } else {
//         $error .='<div class="alert alert-danger" role="alert">
//         Le pseudo est incorrect
//         </div>';
//     }
    
//     $content .=$error;
// };


// ?>



<!-- PARTIE AFFICHAGE -->

<?php
require_once './inc/header.inc.php';
?>

<h1 class="text-center">Connexion</h1>

<form action="" method="POST">
    <div class="container">
       <?= $content; ?>
        <label for="pseudo" class="form-label">Pseudo</label>
        <input type="text" class="form-control" name="pseudo" id="pseudo">

        <label for="mdp" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" name="mdp" id="mdp">

        <input type="submit" class="btn btn-outline-primary btn-lg mt-2" value="Se connecter">
    </div>

</form>

<?php
require_once './inc/footer.inc.php';
?>