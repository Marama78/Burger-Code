<?php

require "database.php";

// vérifier que la page a capturé une donnée 'id'
if(!empty($_GET['id']))
{
    // si vrai, traiter et nettoyer la valeur pour casser le hacking
    $id = checkInput($_GET['id']);
 
}


if(!empty($_POST))
{
    $id = checkInput($_POST['id']);
    $db = Database::connect();
    $statement = $db->prepare("DELETE FROM items WHERE id = ?");
    $statement->execute(array($id));
    Database::disconnect();


    //retourner vers la page index.php
    header("Location: index.php");

}

function checkInput($data){
    $data= trim($data);
    $data= stripslashes($data);
    $data= htmlspecialchars($data);
    //$data= htmlentities($data);

    return $data;
}


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
        <div id="dataBasePower" style = "height:100vh;">
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
                <h1>
                    <strong>Supprimer un item</strong>
                </h1>
                
                <br>
                
                
                <form class="form" role="form" action="delete.php" method="post">
                    <input type = "hidden" name="id" value="<?php echo $id; ?>" />;
                 

                    <p class='alert alert-warning'>Etes vous sûr de vouloir supprimer? </p>

                    <div class="form-group">
                        <br>
                        <button type="submit" class="btn btn-warning btnValidate" >Oui</button>
                        <a href="index.php" class="btn btn-default btnCancel">Non</a>
                    </div>

                </form>
            
            </div>


            



        </div>
        <footer class="footPage text-center footPageDelete">
            <br>
            copyright 2021 - anahoa studio
            <br>
        </footer>
    </body>
</html>