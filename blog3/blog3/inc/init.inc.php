<?php 

//connection a une base de données

$pdoBlog = $pdoBlog = new PDO(
    'mysql:host=localhost;dbname=blog',
    'root',
    '',
    array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,//afficher erreur navigateur
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    )
);

// ouverture de session

session_start();

// chemein du site dans une constante
//ici on defini le chemein absolue dans une constante, on ecrira alors tous les chemin src et href avec cette constante 
//chez l'hebergeur la constante sera la suivante : define('RACINE_SITE', '/');

define('RACINE_SITE', 'coursphp/dialogue');

// variable contenu pour les message
//cette variable ne doit pas contenir d'espace
$contenu = "";


// on inclue le fichier fonctions
require_once 'functions.inc.php';//require once appel une seule fois require appel plusieur fois


?>