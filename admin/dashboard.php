<?php
require_once '../inc/header.inc.php';


if(!userIsAdmin()){
    header('location:../index.php/');
    exit();
}
?>

<h1 class="text-center">Dashboard</h1>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-10 text-center">
            <ul class="list-group">
                <li class="list-group-item m-2 border">
                    <a href="">Gestion membres</a>
                </li>
                <li class="list-group-item m-2 border">
                    <a href="">Gestion profils</a>
                </li>
                <li class="list-group-item m-2 border">
                    <a href="produit.php">Gestion produits</a>
                </li>
            </ul>
        </div>
    </div>
</div>

<?php
require_once '../inc/footer.inc.php';
?>