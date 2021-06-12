<?php

    function checkInput($data){
        $data= trim($data);
        $data= stripslashes($data);
        $data= htmlspecialchars($data);
        //$data= htmlentities($data);

        return $data;
    }

    require 'database.php';

    // vérifier si hackking
    if(!empty($_GET['id'])){
        $id = checkInput($_GET['id']);
    }

    // brancher la base de données
    $db = Database::connect();

    // étant donnée que le id n'est pas clair, on emploie PREPARE au lieu de EXECUTE
    // un piti clin d'oeil sur la dernière ligne =>> WHERE item.id = ?
    $statement = $db->PREPARE('SELECT  items.id,
        items.name,
        items.description,
        items.price,
        items.image,
        categories.name AS category 
        FROM items LEFT JOIN categories ON items.category = categories.id
        WHERE items.id = ?');
    // exécute le programme
    $statement->execute(array($id));
    $item = $statement->fetch();

    // déconnecte la base de données
    Database::disconnect();


    // fonction pour la sécurité de la base de données
   


?>


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
        <div id="dataBasePower">
            <header class="text-center">
                <br>
                <br>
                <br>
                <h1 id="headerLogo"> 
                    
                    <span class="bi bi-shop">
                        </span id=headerLogo>Burger Code<span class="bi bi-shop"></span>
                       
                </h1>
            </header>
            <br>
            <br>
    
        <div class="container admin">
            <div class="row">
            <?php   echo '<div class="col-sm-4">
                    <div class="card viewer">
                        <div class="vignette ">
                            
                                <div class="card-header">
                                                
                                                <img class="card-img funImg" src="../images/' . $item['image'] . '" alt="Menu Classic" srcset=""> 
                                                
                                            <div class="align-self-end">
                                                    <span class="circle">  0</span>
                                                    <span class="price"> ' . number_format((float)$item['price'],2,'.',' ') . '€</span>
                                            
                                                </div>
                                        
                                            </div>
                                        
                                            <div class="card-body">
                                                
                                                    <h1 class="ticket-title">' . $item['name'] . '</h1>
                                                    <p class="ticket-text">' . $item['description'] . '</p>
                                            </div>

                                            <div class="card-footer">
                                                        <button class="btn btn-order" type="button">
                                                            <span class="bi bi-shop-window iconToHide"></span>
                                                            <a>Commander</a>
                                                        </button>

                                            </div>
                         
                        </div>  
                    </div>

                </div>';   ?> 


                <div class="col-sm-6">
                    <h1><strong>Voir un item</strong></h1>
                    <br>
                    <form>
                        <div class="form-group">
                            <label><strong>Nom: </strong></label>
                                <?php 
                                    echo '    ' . $item['name']; 
                                ?>
                        </div>

                        <div class="form-group">
                            <label><strong>Description: </strong> </label>
                                <?php 
                                    echo '    ' . $item['description']; 
                                ?>
                        </div>

                        <div class="form-group">
                            <label><strong>Prix: </strong> </label>
                                <?php 
                                    echo '    ' . number_format((float)$item['price'],2,'.',' ') . '€'; 
                                ?>
                        </div>

                        <div class="form-group">
                            <label><strong>Catégorie: </strong> </label>
                                <?php 
                                    echo '    ' . $item['category']; 
                                ?>
                        </div>

                        <div class="form-group">
                            <label><strong>Image: </strong> </label>
                                <?php 
                                    echo '    ' . $item['image']; 
                                ?>
                        </div>
                    </form>
                    
                    <br>
                    <br>
                    <br>
                    
                    <div class="form-action">
                        <a href="index.php" class="btn btn-primary"><span class="bi bi-backspace"> </span> Retour </a>
                    </div>
                </div>
               
           
            </div>
        </div>    
    
    
        <footer class="footPage h-50 text-center">
        <br>
        copyright 2021 - anahoa studio
        <br>

    </footer>
    
    
    </body>
</html>