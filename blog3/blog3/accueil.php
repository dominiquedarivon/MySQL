<?php 
// j'inclu require ma connection a ma base de donnée
require('inc/init.inc.php');
//je fais ma requête pour afficher un tableau avec les cinq article les plus recente
$requete = $pdoBlog->query("SELECT * FROM articles ORDER BY date_parution DESC LIMIT 0,5");
//Grâce aux valeurs precisées apres le limit de preciser d'abord que je veux commencer au premier elements du tableau et je precise en suite que je veux limiter à 5 éléments
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <!-- Boostrap lux cdnjs -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/5.1.3/lux/bootstrap.min.css" integrity="sha512-B5sIrmt97CGoPUHgazLWO0fKVVbtXgGIOayWsbp9Z5aq4DJVATpOftE/sTTL27cu+QOqpI/jpt6tldZ4SwFDZw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="jumbotron">
        <div class="container">
        <h1 class="display-3">Back office Blog</h1>
        <p class="lead">Page d'accueil</p>
    </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>TITRE</th>
                            <th>CONTENU</th>
                            <th>IMAGE</th>
                            <th>AUTEUR</th>
                            <th>DATE DE PARUTIONS</th>
                        </tr>
                    </thead>

                    <tbody>
                            <?php 
                                while($article = $requete->fetch(PDO::FETCH_ASSOC)) {
                            ?> <!-- Ouverture d'une boucle while // ce n'est pas parce que je suis plus dans un passage PHP que ma boucle ne continu pas // tant que je n'est pas mis l'accolade fermante la boucle continu -->
                                <tr>
                                    <td><?php echo $article['id'];?></td>
                                    <td><?php echo $article['titre'];?></td>
                                    <td><?php echo $article['contenu'];?></td>
                                    <td><img src="<?php echo $article['image']; ?>" alt="illustration" class='img-fluid'></td>
                                    <td><?php echo $article['auteur'];?></td>
                                    <td><?php echo date('d-m-Y' , strtotime($article['date_parution']));?></td>
                                </tr>
                                <?php }?>

                    </tbody>
                </table>


            </div>
        </div>
    </div>
</body>
</html>