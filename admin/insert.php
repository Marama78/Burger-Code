<?php

    require "database.php";

    $nameError = $descriptionError = $categoryError = $priceError = $imageError = $name = $description = $price = $category = $image = "";


    if(!empty($_POST))
    {
        $name= checkInput($_POST['name']);
        $description= checkInput($_POST['description']);
        $price= checkInput($_POST['price']);
        $category= checkInput($_POST['category']);
        $image= checkInput($_FILES['image']['name']);
        $imagePath='../images/' . basename($image);
        $imageExtension = pathinfo($imagePath, PATHINFO_EXTENSION);
        $isSuccess = true;
        $isUploadSuccess = false;


        if(empty($name))
        {
            $nameError = "ce champs ne peux pas être vide";
            $isSuccess = false;
        }
        if(empty($description))
        {
            $descriptionError = "ce champs ne peux pas être vide";
            $isSuccess = false;
        }
        if(empty($price))
        {
            $priceError = "ce champs ne peux pas être vide";
            $isSuccess = false;
        }
        if(empty($category))
        {
            $categoryError = "ce champs ne peux pas être vide";
            $isSuccess = false;
        }
        
        if(empty($image))
        {
            $imageError = "ce champs ne peux pas être vide";
            $isSuccess = false;
        }
        else
        {
            $isUploadSuccess=true;
            
            if($imageExtension != "jpg" && $imageExtension !="png" && $imageExtension!="jpeg" && $imageExtension!="gif")
            {
                $imageError = "les fichiers autorisés dont : .jpg .png .jpeg et .gif";
                $isUploadSuccess = false;
            }
            if(file_exists($imagePath))
            {
                $imageError = "Le fichier existe déja";
                $isUploadSuccess = false;
            }
            if($_FILES["image"]["size"] > 500000) // 500ko
            {
                $imageError = "le fichier ne doit pas dépasser 500 ko";
                $isUploadSuccess = false;
            }
            if($isUploadSuccess)
            {
               if(!move_uploaded_file($_FILES["image"]["tmp_name"],$imagePath))
               {
                $imageError = "impossible de charger l'image";
                $isUploadSuccess = false;
               }
            }
        } // end else

        if($isSuccess && $isUploadSuccess)
        {
            $db = Database::connect();
            $statement = $db->prepare("INSERT INTO items (name,description,price,category,image) VALUES ( ? , ? , ? , ? , ? )");
            $statement->execute(array($name,$description,$price,$category,$image));
            Database::disconnect();
            header("Location: index.php");


        }

    }


    function checkInput($data){
        $data= trim($data);
        $data= stripslashes($data);
        $data= htmlspecialchars($data);
    
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
        <div id="dataBasePower" style="height: 1000px">
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
                    <strong>Ajouter un item</strong>
                </h1>
                
                <br>
                
                
                <form class="form" role="form" action="insert.php" method="post" enctype="multipart/form-data">
                    <div class = "form-group">
                        <label for="name"><strong>Nom: </strong></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder = "Nom" value="<?php echo $name; ?>">
                            <span class="help-inline"><?php echo $nameError; ?></span>
                    </div>

                    <div class="form-group">
                    <label for="description"><strong>Description: </strong> </label>
                        <input type="text" class="form-control" id="description" name="description" placeholder = "Description" value="<?php echo $description; ?>">
                            <span class="help-inline"><?php echo $descriptionError; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="price"><strong>Prix: </strong> </label>
                        <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder = "Prix" value="<?php echo $price; ?>">
                            <span class="help-inline"><?php echo $priceError; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="category"><strong>Choisir la catégorie: </strong> </label>
                        <select class="form-control" id="category" name="category">
                            <?php
                                $db = Database::connect();

                                    foreach($db->query("SELECT * FROM categories") as $row)
                                    {
                                        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                    }

                                Database::disconnect();
                            ?>
                        </select>
                            <span class="help-inline"><?php echo $categoryError; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="image"><strong>Sélectionner une image: </strong> </label>
                        <br>
                        <input type="file" id="image" name = "image"></input>
                        <br>
                        <span class="help-inline"><?php echo $imageError; ?></span>
                    </div>

                    

                    
                    
                    
                    <div class="form-group">
                        <br>
                    <br>
                    <br><button type="submit" class="btn btn-success" ><span class="bi bi-pen"> </span> Ajouter </button>
                        <a href="index.php" class="btn btn-primary"><span class="bi bi-backspace"> </span> Retour </a>
                        </div>

                </form>


            </div>
        </div>
    </body>
</html>