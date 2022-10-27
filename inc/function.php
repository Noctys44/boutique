<?php

function userConnected() {
    if(isset($_SESSION['membre'])) {
        return true;
    } else {
        return false;
    }
}


function userIsAdmin() {
    if(userConnected() && $_SESSION['membre']['statut'] === 1) {
        return true;
    } else {
        return false;
    }
}

function creation_panier() {
    if(!isset($_SESSION['panier'])){  // S'il n'y a pas de session alors je crée ma session qui va contenir l'id, la quantite et le prix
        $_SESSION['panier'] = array();
        $_SESSION['panier']['id_produit'] = array();
        $_SESSION['panier']['quantite'] = array();
        $_SESSION['panier']['prix'] = array();
    }
}

// Fonction d'ajout au panier
function ajoutProduit($id_produit, $quantite, $prix){ // Qui prend id, quantite et prix
    creation_panier(); // J'exécute la function de creation lors de l'ajout

    // Je vérifie si le produit est déjà dans la session panier
    // array_search() Recherche dans un tableau la première clé associé à la valeur
    $position = array_search($id_produit, $_SESSION['panier']['id_produit']);

    if($position === true){ // Si le produit est trouvé alors j'incrémente la quantité
        $_SESSION['panier']['quantite'][$position] += $quantite;
    } else { // Sinon je l'ajoute comme un nouveau produit. [] à la fin permet d'ajoute un nouveau produit et non écraser le produit qui était dans le panier.
        $_SESSION['panier']['id_produit'][] += $id_produit;
        $_SESSION['panier']['quantite'][] += $quantite;
        $_SESSION['panier']['prix'][] += $prix;
    }
}

// Cette fonction calcul le montant total
function montantTotal(){
    $total = 0;
    for($i = 0; $i < count($_SESSION['panier']['id_produit']); $i++){
        $total += $_SESSION['panier']['quantite'][$i] * $_SESSION['panier']['prix'][$i];
        return $total;
    }
}

function retireProduit($id_produit){

    // Je cherche la position du produit dans le panier
    $positionProduit = array_search($id_produit, $_SESSION['panier']['id_produit']);

    // array_plice() remplace une portion d'un tableau
    // En mode 1 remplace et reclasse les éléments dans le tableau
    array_splice($_SESSION['panier']['id_produit'],$positionProduit, 1);
    array_splice($_SESSION['panier']['quantite'],$positionProduit, 1);
    array_splice($_SESSION['panier']['prix'],$positionProduit, 1);

}

?>