<?php 

//je cree ma fonction de debug
    function debug($mavar){
        echo "<br><pre class='alert alert-warning'>";
        var_dump($mavar);
        echo "</pre>";
    }


//je cree ma function pour verifier que l'utilisateur est connecté

    function estConnecte () {
        if (isset($_SESSION['membre'])) {//si dans la superglobale $_SESSIONS je recupere un indice memebre, cela signifie que la personne est connecte
            return true; //il est connecté
        }else {
            return false; //il n'est pas conncte
        }
    }


//Je verifie que le membre qui est connecte est admin

    function estAdmin () {
        if (estConnecte() && $_SESSION['membres']['statut'] == 1) { // si l'utilisateur est connecte et que son  statut est 1 alors il est admin
            //je verifie que l'on remplie les conditions dde la fonction estConnecte
            //et que dans ma table membre dans la colonne statut je récupere bien l'integer 1 qui correspond à ADMIN
            return true; //connecte est admin
        }else {
            return false;//connecte mais pas admin
        }
    }

?>