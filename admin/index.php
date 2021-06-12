<!DOCTYPE html>
<html>
    <head>
        <title>Burger code</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
       
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Holtwood+One+SC&display=swap" rel="stylesheet">
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">


        <link rel="stylesheet" href="../css/styles.css">
    </head>

    <body>
        <div id="dataBasePower" >
            
            <header class="text-center">
             
                <br>
                <br>
                <br>
                
                <h1 id="headerLogo"> 
                    <span class="bi bi-shop">
                        </span id=headerLogo>Burger Code<span class="bi bi-shop"></span>
                       
                </h1>
                
                <br>
                <br>
            
            </header>
            

            <div class="container admin">
                <div class="row bg-light">
                    <h1>
                        <strong> Liste des items </strong> 
                        <a href="insert.php" class="btn btn-success">
                            <span class="bi bi-plus-circle"></span>
                            Ajouter
                        </a>
                        <a href="../index.php" class="btn btn-warning">
                            <span class="bi bi-plus-circle"></span>
                            Accéder au Site Web
                        </a>
                    </h1>

                    <table class="table table-striped table-bordered bg-light">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Description</th>
                                <th>Prix</th>
                                <th>Catégorie</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                // brancher la base de données en appelant la fonction connect() dans le fichier database.php
                                require 'database.php';
                                $db=Database::connect();
                                
                                // récupérer les informations
                                $statement = $db->query('SELECT items.id,
                                items.name,
                                items.description,
                                items.price,
                                categories.name AS category 
                                FROM items LEFT JOIN categories ON items.category = categories.id
                                ORDER by items.id DESC');
                                // lire chacune des lignes jusqu'à la fin mot clé = FETCH()
                                // afficher grâce à echo dans la page HTML
                                while ($item = $statement->fetch()) {
                                    echo '<tr>';
                                    echo '<td>' . $item['name'] . '</td>';
                                    echo '<td>' . $item['description'] . '</td>';
                                    echo '<td>' . number_format((float)$item['price'],2,'.',' ') . ' €</td>';
                                    echo '<td>' . $item['category'] . '</td>';
                                    echo '<td width=400>';
                                    echo '<a href="view.php?id=' . $item['id'] . '" class="btn btn-outline-dark btnView"><span class="bi bi-image"> Voir</span></a>';
                                    echo ' ';
                                    echo  '<a href="update.php?id=' . $item['id'] . '" class="btn btn-primary btnUpdate"><span class="bi bi-pen"> Modifier</span></a>';
                                    echo ' ';
                                    echo '<a href="delete.php?id=' . $item['id'] . '" class="btn btn-danger btnDelete"><span class="bi bi-x-circle"> Supprimer</span></a>';
                                    echo '</td>';
                                    echo '</tr>';
                                }

                                // libérer et déconnecter la base de données pour libérer le flux
                                Database::disconnect();

                            ?>
                          
                        </tbody>
                    
                    
                    </table>











                </div>

            </div>
       



                            
        <footer class="footPage text-center">
        <br>

        copyright 2021 - anahoa studio
        <br>

        </footer>

    </div>

    </body>

</html>