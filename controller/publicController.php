<?php
/*
Gère le site pour un visiteur non connecté
*/

// JSON pour l'API
if(isset($_GET['json'])){
    $locations = getLocations($db);
    if(!is_string($locations)){
        echo json_encode($locations);
    }
    exit();
}

// Si on essaye de se connecter
if(isset($_GET['connect'])){

    // si on a envoyé le formulaire
    if(isset($_POST['username'],$_POST['userpwd'])){
        // protection du champs qui sera dans la requête
        $username = htmlspecialchars(strip_tags(trim($_POST['username'])),ENT_QUOTES);
        // protecion pour les espaces vide
        $userpwd = trim($_POST['userpwd']);
        // tentative de connexion
        $connect = connectAdministrator($db,$username,$userpwd);
        // connexion réussie
        if($connect===true){
            header("Location: ./");
            exit();
        }else{
            $error = "Login et/ou mot de passe incorrecte(s)";
        }
    }

    // appel de la vue
    include "../view/public/connect.view.html.php";
    exit();
}

// si on est sur l'accueil chargement de tous les `Adresses`
$datas = getAllAdresses($db); // on obtient un string (Erreur SQL), un tableau vide (Pas de datas), un tableau non vide (On a des datas)
// appel de la vue
include "../view/public/homepage.view.html.php";