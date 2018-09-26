<!doctype html>
<!-- Faire le double header ressemblant à EUROSPORT ! :D  -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TP Web</title>
    <link rel="stylesheet" type="text/css" href="../resources/css/main.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css"
          integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">


</head>
<body>

<?php
// ***********
// EXEMPLE CODE ENVOI REQUETE DE TYPE SELECT
// utilisation de PDO
// ***********


define("_LOGIN_", "root");
define("_PASSWD_", "");
define("_SERVERHOST_", "localhost");
define("_BDD_", "mytransporter");

$pdo = "";

try {
    $strConnection = "mysql:host=" . _SERVERHOST_ . ";dbname=" . _BDD_;
    $arrExtraParam = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
    $pdo = new PDO($strConnection, _LOGIN_, _PASSWD_, $arrExtraParam);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
    $msg = '<p>ERREUR PDO a la connexion BDD: ' . $e->getMessage() . "</p>";
    die($msg);
}


$query = "SELECT * FROM colis";
//$tabvaleurs = array();
try {
    $resultat = $pdo->prepare($query);
    $resultat->execute();


} catch (PDOException $e) {
    $msg = '<p>ERREUR PDO requete Select : ' . $e->getMessage() . "</p>";
    die($msg);
}

// combien de lignes ont été retournées par la requete ?
//$nblignes=$resultat->rowCount();

?>
<div class="menu"><!-- menu.html --></div>

<div class="container-fluid contain">
    <h1>Liste des Colis</h1>
    <div class="row">
        <section class="col-md-9 block-colis">
            <div class='align-h'>
                    <?php
                    while ($ligne = $resultat->fetch()) {
                        $libelle = $ligne['libelleColis'];
                        $adresse = $ligne['adresseLivraison'];
                        $cp = $ligne['cpLivraison'];
                        $ville = $ligne['villeLivraison'];
                        $type = $ligne['type'];

                        echo "
                <article class='colis col-md-3'><img src='../resources/img/box2.png' class='img-responsive'>
                    <div class='category'><span>$type</span></div>
                    <hr>
                    <p class='citys'>" . $libelle . "</p>
                    <p class='price'><a href='#'>" . $cp . " " . $ville . "</a></p>
                </article>
               
           ";
                    }

                    ?>
        </section>
        <aside class="col-md-3 block-right">
            <p>Commander</p>
            <form action="">
                <label for="nom">Nom :</label><br><input id="nom" type="text">
                <label for="prenom">Prenom : </label><br><input id="prenom" type="text">
                <a href="#" class="btn">Valider</a>
            </form>
        </aside>
    </div>
</div>


<script src="../node_modules/jquery/dist/jquery.js"></script>
<script src="../resources/scripts/t.js"></script>

</body>

</html>

