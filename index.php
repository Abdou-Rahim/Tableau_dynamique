<?php
require_once 'vendor/autoload.php';

use app\Helper\{
    NumberHelper,
    TableHelper,
    URLHelper
};
//--------------------- Initialiser la base de donnees -------------------------
    
$bdd = new PDO("mysql:host=localhost;dbname=products", "root", "");


$page = (int)($_GET['p'] ?? 1);


// --------------Section de recherche-----------------------------------
$query = "SELECT * FROM data";
$queryCount = "SELECT id FROM data";
$params = [];
$sortable = ['id', 'nom', 'prix', 'ville', 'adresse'];

if(isset($_GET['form_valid'])){  
    
    if(!empty($_GET['q'])){
        
        $query .= " WHERE ville LIKE :ville";
        $queryCount .= " WHERE ville LIKE :ville";
        $params['ville'] = "%" . $_GET['q'] . "%";
    }else{
        $erreur = "Veuillez remplir d'abord le champs de recherche!";
    }    
}
//-------------Organisation-----------------------------
if(!empty($_GET['sort']) && in_array($_GET['sort'], $sortable)){
    $direction = $_GET['dir'] ?? 'asc';
    if(!in_array($direction, ['asc', 'desc'])){
        $direction = 'asc';
    }
    $query .= " ORDER BY " . $_GET['sort'] . " " . $direction;

}

//-----------------------section de pagination -------------------------------
$nombre_element_par_page = 7;
$requete = $bdd->prepare($queryCount);
$requete->execute($params);
$nombre_total_element = $requete->rowCount();
$nombre_de_page = ceil($nombre_total_element / $nombre_element_par_page);

$debut = ($page - 1) * $nombre_element_par_page;

// ----------------------Section Affichage ---------------------------------------
$query .= " LIMIT " . $nombre_element_par_page . " OFFSET $debut";

$statement = $bdd->prepare($query);
$statement->execute($params);
$donnes = $statement->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>tableau dynamique</title>
    <style>
        .form-group{
            margin-bottom: 10px;
        }
        
    </style>
</head>
<body class="p-4" >
    
    <?php if(isset($erreur)): ?>
        <div class="alert-danger">
            <?= $erreur  ?>
        </div>
    <?php  endif ?>  
    
    
    <h2 class="mb-3" >Les biens immobiliers</h2>    

    <form action="" class="mb-3" >
        <div class="form-group">
            <input type="text" class="form-control" placeholder="rechercher par ville" name="q" value="<?php if(isset($_GET['q'])){echo htmlspecialchars($_GET['q']);} ?>">
        </div>
        <input type="submit" class="btn btn-primary" name="form_valid" value="Recherher">
        <a href="/Tableau_dynamique" class="btn btn-primary">Refresh</a>
       
    </form>

    <table class="table table-striped" >
        <thead>
            <th><?= TableHelper::sort('id', 'ID', $_GET)   ?></th>
            <th><?= TableHelper::sort('nom', 'Nom', $_GET)   ?></th>
            <th><?= TableHelper::sort('prix', 'Prix', $_GET)   ?></th>
            <th><?= TableHelper::sort('ville', 'Ville', $_GET)   ?></th>
            <th><?= TableHelper::sort('adresse', 'Adresse', $_GET)   ?></th>
        </thead>
        <tbody>
            <?php foreach($donnes as $donne): ?>           
            <tr>
                <td> #<?= $donne['id'] ?> </td>
                <td><?= $donne['nom'] ?></td>
                <td><?= NumberHelper::format($donne['prix']) ?></td>
                <td><?= $donne['ville'] ?></td>
                <td><?= $donne['adresse'] ?></td>
            </tr>
            <?php endforeach ?>            
        </tbody>        
    </table>
    <?php  if($nombre_de_page > 1 && $page > 1):   ?>
        <a href="?<?= URLHelper::with_param($_GET, "p", $page - 1) ?>" class="btn btn-primary">page precedent</a>
    <?php endif ?>
    <?php  if($nombre_de_page > 1 && $page < $nombre_de_page):   ?>
        <a href="?<?= URLHelper::with_param($_GET, "p", $page + 1) ?>" class="btn btn-primary">page suivante</a>
    <?php endif ?>
    
    
</body>
</html>