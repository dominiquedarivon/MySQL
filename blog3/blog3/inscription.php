<?php 
// 1- Require de init.inc.php
require_once('inc/init.inc.php');

// 2-Inscription sur la BDD
if(!empty($_POST)){
    /* Les if qui suivent vont permettre de vérifier si les valeurs passées dans $_POST correspondent bien à ce qui est attendu en BDD */

    if(!isset($_POST['civilite']) || $_POST['civilite'] != 'm' && $_POST['civilite'] != 'f'){ /* Je vérifie que je récupère une info dans civilité et qu'elle correspond soit à m soit à f */
        $contenu .= "<div class=\"alert alert-warning\">La civilité n'est pas valable !</div>";
    }

    if(!isset($_POST['prenom']) || strlen($_POST['prenom']) < 2 || strlen($_POST['prenom']) > 20) {/* si le prenom n'est pas defini ou que le prenom fait moins de 1 caractères ou plus de 20 alors erreur */
        $contenu .= "<div class=\"alert alert-warning\">Votre prénom doit faire entre 2 et 20 caractères !</div>";
    }

    if(!isset($_POST['nom']) || strlen($_POST['nom']) < 2 || strlen($_POST['nom']) > 20) {/* si le nom n'est pas defini ou que le nom fait moins de 1 caractères ou plus de 20 alors erreur */
        $contenu .= "<div class=\"alert alert-warning\">Votre nom doit faire entre 2 et 20 caractères !</div>";
    }

    if(!isset($_POST['email']) || strlen($_POST['email']) > 50 || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {/* Je vérifie que l'email n'est pas vide, qu'il fait moins de 50 caractères et qu'il est conforme grâce à filter_var() accompagné des FILTER_VALIDATE_EMAIL */
        $contenu .= "<div class=\"alert alert-warning\">Votre email n'est pas conforme !</div>";
    }

    if(!isset($_POST['pseudo']) || strlen($_POST['pseudo']) < 4 || strlen($_POST['pseudo']) > 20) {/* si le pseudo n'est pas defini ou que le pseudo fait moins de 4 caractères ou plus de 20 alors erreur */
        $contenu .= "<div class=\"alert alert-warning\">Votre pseudo doit faire entre 4 et 20 caractères !</div>";
    }

    if(!isset($_POST['mdp']) || strlen($_POST['mdp']) < 4 || strlen($_POST['mdp']) > 50) {/* si le mdp n'est pas defini ou que le mdp fait moins de 4 caractères ou plus de 50 alors erreur */
        $contenu .= "<div class=\"alert alert-warning\">Votre mot de passe doit faire entre 4 et 50 caractères !</div>";
    }

    if(!isset($_POST['adresse']) || strlen($_POST['adresse']) < 4 || strlen($_POST['adresse']) > 70) {/* si l'adresse n'est pas definie ou que l'adresse fait moins de 4 caractères ou plus de 70 alors erreur */
        $contenu .= "<div class=\"alert alert-warning\">Votre adresse doit faire entre 4 et 70 caractères !</div>";
    }

    if(!isset($_POST['code_postal']) || !preg_match('#^[0-9]{5}$#', $_POST['code_postal'])){/* Grâce à preg_match , on vérifie que la chaîne de caractère correspond à ce qu'on autorise dans le regex => en l'occurence on autorise les chiffres de 0 à 9 et on en veut exactement 5 */
        $contenu .= "<div class=\"alert alert-warning\">Le code postal n'est pas valable !</div>";
    }

    if(!isset($_POST['ville']) || strlen($_POST['ville']) < 1 || strlen($_POST['ville']) > 50) {/* si la ville n'est pas definie ou que la ville fait moins de 1 caractères ou plus de 50 alors erreur */
        $contenu .= "<div class=\"alert alert-warning\">Votre ville doit faire entre 1 et 50 caractères !</div>";
    }
    
    if(empty($contenu)) {//si la variable $contenu est vide alors je n'ai pas d'erreurs et je peux lancer ma requête 
        $membre = $pdoBlog->prepare("SELECT * FROM membres WHERE pseudo = :pseudo ");
        $membre->execute(array(
            ':pseudo' => $_POST['pseudo'],
        ));

        if($membre->rowCount() > 0) {/* si au décompte de cette requête on obtient pas 0 c'est que le pseudo existe déjà */
            $contenu .= "<div class=\"alert alert-warning\">Ce pseudo est indisponible, veuillez en choisir un autre.</div>";
        } else {/* c'est que le pseudo est dispo, on entre les infos en BDD */
            $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);/* Grâce à la fonction prédéfinir password_hash je hash le mot de passe et je lui dis ensuite de quelle façon grâce à PASSWORD_DEFAULT */

            $succes = $pdoBlog->prepare(" INSERT INTO membres (civilite, prenom, nom, email, pseudo, mdp, adresse, code_postal, ville, statut) VALUES (:civilite, :prenom, :nom, :email, :pseudo, :mdp, :adresse, :code_postal, :ville, 0) ");

            $succes->execute(array(
                ':civilite' => $_POST['civilite'],
                ':prenom' => $_POST['prenom'],
                ':nom' => $_POST['nom'],
                ':email' => $_POST['email'],
                ':pseudo' => $_POST['pseudo'],
                ':mdp' => $mdp, /* Ici je récupère le mot de passe de la variable qui a été hashé */
                ':adresse' => $_POST['adresse'],
                ':code_postal' => $_POST['code_postal'],
                ':ville' => $_POST['ville'],
            ));

            if($succes){
                $contenu .="<div class=\"alert alert-success\">Vous êtes bien inscrit.e sur le site, bienvenue !<br>
                <a href=\"\">Cliquez ici pour vous connecter</a></div>";
            }else{
                $contenu .= "<div class=\"alert alert-danger\">Erreur lors de l'inscription</div>";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Inscription</title>
    <!-- BOOTSWATCH CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/5.1.3/lux/bootstrap.min.css" integrity="sha512-B5sIrmt97CGoPUHgazLWO0fKVVbtXgGIOayWsbp9Z5aq4DJVATpOftE/sTTL27cu+QOqpI/jpt6tldZ4SwFDZw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    <div class="p-5 bg-primary">
        <div class="container">
            <h1 class="display-3 text-white">Inscription Blog</h1>
            <p class="lead text-white">Inscrivez-vous sur notre site !</p>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-8 mx-auto">
            <?php echo $contenu; ?>
                <form action="#" method="POST">

                    <div class="mb-3">
                        <label for="civilite">Civilité *</label>
                        <input type="radio" name="civilite" id="civilite" value="f" class="form-check-input" checked>Féminin
                        <input type="radio" name="civilite" id="civilite" value="m" class="form-check-input">Masculin

                        <!-- OPTION AVEC SELECT
                            <select name="civilite" id="civilite">
                            <option value="f">Féminin</option>
                            <option value="m">Masculin</option>
                            </select> -->

                        <!-- Quand j'ai un enum en bdd -> je dois mettre soit des boutons de types radio, soit un select avec des options. Il faudra focément que les options ou les boutons radio aient une "value" -->
                    </div>

                    <div class="mb-3 row">

                        <div class="col">
                            <label for="prenom">Prénom *</label>
                            <input type="text" name="prenom" id="prenom" class="form-control" required>
                        </div>

                        <div class="col">
                            <label for="nom">Nom *</label>
                            <input type="text" name="nom" id="nom" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3 row">

                        <div class="col">
                            <label for="email">Email *</label>
                            <input type="text" name="email" id="email" class="form-control" required>
                        </div>

                        <div class="col">
                            <label for="pseudo">Pseudo *</label>
                            <input type="text" name="pseudo" id="pseudo" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3 row">

                        <div class="col">
                            <label for="adresse">Adresse *</label>
                            <input type="text" name="adresse" id="adresse" class="form-control" required>
                        </div>

                        <div class="col">
                            <label for="ville">Ville *</label>
                            <input type="text" name="ville" id="ville" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="mb-3 row">

                        <div class="col">
                            <label for="code_postal">Code postal *</label>
                            <input type="text" name="code_postal" id="code_postal" class="form-control" required>
                        </div>

                        <div class="col">
                            <label for="mdp">Mot de passe *</label>
                            <input type="password" name="mdp" id="mdp" class="form-control" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">S'inscrire</button>

                </form>

            </div>
        </div>
    </div>


    <!-- BOOTSWATCH JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>