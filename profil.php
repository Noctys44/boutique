<?php

require_once './inc/init.php';


if(!userConnected())
{
    header('location:connexion.php');
}

if(userIsAdmin())
{
    $content .='<div class="alert alert-primary text-center" role="alert">
        Bonjour Admin
        </div>';
} else {
        $content .='<div class="alert alert-primary text-center" role="alert">
        Bienvenue
        </div>';
};


// if(isset($_SESSION['membre']))
// {
//     // echo 'Bonjour';

//     // "<div>" . 'Votre pseudo : ' . ($_SESSION['membre']['pseudo']) . "</div>" . 
//     // "<div>" . 'Votre nom : ' . ($_SESSION['membre']['nom']) . "</div>" .
//     // "<div>" . 'Votre prénom : ' . ($_SESSION['membre']['prenom']) . "</div>" .
//     // "<div>" . 'Votre email : ' . ($_SESSION['membre']['email']) . "</div>" .
//     // "<div>" . 'Votre civilité : ' . ($_SESSION['membre']['civilite']) . "</div>" .
//     // "<div>" . 'Votre ville : ' . ($_SESSION['membre']['ville']) . "</div>" .
//     // "<div>" . 'Votre code postal : ' . ($_SESSION['membre']['code_postal']) . "</div>" .
//     // "<div>" . 'Votre adresse : ' . ($_SESSION['membre']['adresse']) . "</div>" .
//     // "<div>" . 'Votre statut : ' . ($_SESSION['membre']['statut']) . "</div>" ;
// }

$req = $pdo->query('SELECT * FROM membre WHERE pseudo = "$pseudo"');
$user = $req->fetch(PDO::FETCH_ASSOC);

$_SESSION["req"]=$user;

$profil ='<div class="text-center">' . 'Votre pseudo : ' . ($_SESSION['membre']['pseudo']) . "</div>" . 
            '<div class="text-center">' . 'Votre nom : ' . ($_SESSION['membre']['nom']) . "</div>" .
            '<div class="text-center">'. 'Votre prénom : ' . ($_SESSION['membre']['prenom']) . "</div>" .
            '<div class="text-center">' . 'Votre email : ' . ($_SESSION['membre']['email']) . "</div>" .
            '<div class="text-center">' . 'Votre civilité : ' . ($_SESSION['membre']['civilite']) . "</div>" .
            '<div class="text-center">' . 'Votre ville : ' . ($_SESSION['membre']['ville']) . "</div>" .
            '<div class="text-center">' . 'Votre code postal : ' . ($_SESSION['membre']['code_postal']) . "</div>" .
            '<div class="text-center">' . 'Votre adresse : ' . ($_SESSION['membre']['adresse']) . "</div>" .
            '<div class="text-center">' . 'Votre statut : ' . ($_SESSION['membre']['statut']) . "</div>" ;

        $content .=$profil;





?>

<?php

require_once './inc/header.inc.php';

?>

<h1 class="text-center">Profil</h1>
    <div class="container">
    <?php echo $content ?>
    </div>


<?php
require_once './inc/footer.inc.php';
?>