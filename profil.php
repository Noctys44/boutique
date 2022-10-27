<?php

require_once './inc/header.inc.php';


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


$req = $pdo->query('SELECT * FROM membre WHERE pseudo = "$pseudo"');
$user = $req->fetch(PDO::FETCH_ASSOC);

$_SESSION["req"]=$user;

$profil ='<div class="text-center">' . 'Votre pseudo : ' . ($_SESSION['membre']['pseudo'] ) . '</div>' . 
            '<div class="text-center">' . 'Votre nom : ' . ($_SESSION['membre']['nom']) .  '<a class="text-decoration-none" href="?action=modification_nom&nom='.$_SESSION['membre']['nom'].'"><img style="width:15px; height:auto; margin-left:20px;" src="./photo/icone_update.png"><i class="fas fa-edit"></i></a>'. "</div>" .
            '<div class="text-center">'. 'Votre prénom : ' . ($_SESSION['membre']['prenom']) .  '<a class="text-decoration-none" href="?action=modification_prenom&prenom='.$_SESSION['membre']['prenom'].'"><img style="width:15px; height:auto; margin-left:20px;" src="./photo/icone_update.png"><i class="fas fa-edit"></i></a>'. "</div>" .
            '<div class="text-center">' . 'Votre email : ' . ($_SESSION['membre']['email']) .   '<a class="text-decoration-none" href="?action=modification_email&email='.$_SESSION['membre']['email'].'"><img style="width:15px; height:auto; margin-left:20px;" src="./photo/icone_update.png"><i class="fas fa-edit"></i></a>'."</div>" .
            '<div class="text-center">' . 'Votre civilité : ' . ($_SESSION['membre']['civilite']) . "</div>" .
            '<div class="text-center">' . 'Votre ville : ' . ($_SESSION['membre']['ville']) .  '<a class="text-decoration-none" href="?action=modification_ville&ville='.$_SESSION['membre']['ville'].'"><img style="width:15px; height:auto; margin-left:20px;" src="./photo/icone_update.png"><i class="fas fa-edit"></i></a>'. "</div>" .
            '<div class="text-center">' . 'Votre code postal : ' . ($_SESSION['membre']['code_postal']) .  '<a class="text-decoration-none" href="?action=modification_postal&code_postal='.$_SESSION['membre']['code_postal'].'"><img style="width:15px; height:auto; margin-left:20px;" src="./photo/icone_update.png"><i class="fas fa-edit"></i></a>'. "</div>" .
            '<div class="text-center">' . 'Votre adresse : ' . ($_SESSION['membre']['adresse']) .   '<a class="text-decoration-none" href="?action=modification_adresse&adresse='.$_SESSION['membre']['adresse'].'"><img style="width:15px; height:auto; margin-left:20px;" src="./photo/icone_update.png"><i class="fas fa-edit"></i></a>'. "</div>" .
            '<div class="text-center">' . 'Votre statut : ' . ($_SESSION['membre']['statut']) . "</div>" ;

        $content .=$profil;

        if (isset($_GET['action']) && $_GET['action'] == 'modification_name') {

            $res = $pdo->query("SELECT *
                            FROM membre 
                            WHERE nom = '$_GET[nom]'");
                
        }

        if (isset($_GET['action']) && $_GET['action'] == 'modification_firstname') {

            $res = $pdo->query("SELECT *
                            FROM membre 
                            WHERE prenom = '$_GET[prenom]'");
                   
        }

        if (isset($_GET['action']) && $_GET['action'] == 'modification_email') {

            $res = $pdo->query("SELECT *
                            FROM membre 
                            WHERE email = '$_GET[email]'");
        
        }

        if (isset($_GET['action']) && $_GET['action'] == 'modification_ville') {

            $res = $pdo->query("SELECT *
                            FROM membre 
                            WHERE ville = '$_GET[ville]'");
                            
        
        }

        if (isset($_GET['action']) && $_GET['action'] == 'modification_postal') {

            $res = $pdo->query("SELECT *
                            FROM membre 
                            WHERE code_postal = '$_GET[code_postal]'");
        
        }

        if (isset($_GET['action']) && $_GET['action'] == 'modification_adresse') {

            $res = $pdo->query("SELECT *
                            FROM membre 
                            WHERE adresse = '$_GET[adresse]'");
        
        }
        
?>


<h1 class="text-center">Profil</h1>
    <div class="container">
    <?= $content ?>
    </div>


<?php
require_once './inc/footer.inc.php';
?>