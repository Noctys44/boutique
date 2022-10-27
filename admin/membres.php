<?php
require_once '../inc/header.inc.php';


if(!userIsAdmin()){
    header('location:../index.php/');
    exit();
}

if(isset($_GET['action']) && $_GET['action'] == 'suppression')
{
    if($pdo->query("DELETE FROM membre WHERE id_membre = '$_GET[id_membre]' AND statut = 0")){
    
    header ('location:membres.php');
    $content .= '<div class="alert alert-success" role="alert">
    Le membre a bien été supprimé
    </div>';
    } else {
        header ('location:membres.php');
        $content .= '<div class="alert alert-danger" role="alert">
        L\'admin ne peut pas être supprimé
        </div>';
    }
} 

// $reqCommande = $pdo->query("SELECT count(m.id_membre)                     
//                             FROM membre m
//                             INNER JOIN commande c
//                             ON m.id_membre = c.id_commande");
                            
$reqCommande = $pdo->query("SELECT count(c.id_commande)                     
                            FROM commande c
                            INNER JOIN membre m
                            ON m.id_membre = c.id_commande");


$res = $pdo->query("SELECT id_membre,pseudo,nom,prenom,email,civilite,ville,code_postal,adresse  
                    FROM membre ");
$content .= '<h1 class="text-center display-4">Liste des ' . $res->rowCount() . ' utilisateurs enregistrés</h1>';

// INNER JOIN commande ON '".$_SESSION['membre']['id_membre']."' = '". $_SESSION['panier']['id_commande']"'

$content .= '<table class="table table-striped"><tr>';
// Faire une boucle pour afficher les membres dans la table
// tant que $i est inférieur à la liste des colones alors on va tourner autant de fois qu'il y a de colone à afficher

for ($i = 0; $i < $res->columnCount(); $i++) {

    //getColumnMeta() Récupère les métadonnées d'une colonne indexée à 0 dans un jeu de résultats sous la forme d'un tableau associatif.
    
    $colonne = $res->getColumnMeta($i); // Récupérer les infos de chaque colone (LES en-tête) . Tout le résultat sera dans un tableau
    
    $content .= '<th class="text-center">' . $colonne['name'] . '</th>';
}

$content .= '<th>Delete</th>';
$content .= '<th>Nombres de commandes</th>';


$content .= '</tr>';


// tant qu'il y a des lignes ( des données à afficher) Je vais récupérer le contenu de chaque ligne
while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
    $content .= '<tr>';

    foreach ($row as $key => $value) {
        
            // Ici je coupe la longueur du texte qui sera affiché avec substr()
            $value = substr($value,0, 100);
            $content .= "<td class=\"align-middle text-center\">$value</td>";
        
    }

    $content .= "<td class=\"align-middle\"><a href=?action=suppression&id_membre=$row[id_membre]>Delete</a></td>";

    while($rCommande = $reqCommande->fetch(PDO::FETCH_ASSOC)){

        foreach($rCommande as $key => $value){

        $content .= "<td class=\"align-middle\">$value</td>";
        }
    }

    $content .= '</tr>';
}

$content .= '</table>';

?>




<h1 class="text-center">Gestion des membres</h1>

<?= $content; ?>



<?php
require_once '../inc/footer.inc.php';
?>