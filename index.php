<?php require 'admin/database.php';?>

<!DOCTYPE html>
<html>
    <head>
        <title>Burger code</title>
        <meta charset='utf-8'/>
         <meta name="viewport" content="width=device-width, initial-scale=1.0">
       
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Holtwood+One+SC&display=swap" rel="stylesheet">
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">


        <link rel="stylesheet" href="css/styles.css">
     <?php   
    
    echo'
    <script>

        // all the variables needed for the mainpage
        // the "snacks" with the corresponding panel "#panel6" was added recently
        // two solutions : 
        //1 - correct the html
        //2 - move the argument inside the script
        // I ve choosen the second option, you are free to use the first one. :)

        
        
        // se connecter sur la base de données
        var contentMenu = [];
        var contentTabPanel = [];
        ';
        $db = Database::connect();
        // accéder aux données de la table [catégories]
        $statement = $db->query("SELECT * FROM categories");
        $categories = $statement->fetchAll();
        
        $menu = "";

        foreach($categories as $state)
        {
        echo 'contentMenu.push("' . $state["name"] . '");';
        echo 'contentTabPanel.push("#panel' . $state["id"] . '");';
        }
        
        echo'   
        
        var _index;
        var target;
        var oldTarget;


        function ScrollToUp(){
            target=contentTabPanel[_index];

            // hide the .footpage class  items
            $(".footPage").removeClass("h-50");
            $(".footPage").css({"height":"0"});

            // .menuSpy is show on mobile
            $("#menuSpy").css({"width":"10"});   
        

            if(target!=oldTarget){
                $(target).fadeOut(40);
                $(target).find(".card").hide(0);

                window.scrollTo(0,0) ;
                $(target).fadeIn(500);
            $(".card").show(200);

                oldTarget = target;
            };
            $(".footPage").show(500);


            if(  $(".navbar-collapse").hasClass("show"))
            {
                $(".nav-item").hover(
                    function(){
                        $(this).css({"background":"#fff"});
                    },
                    function(){
                        $(this).css({"background":"rgba(0,0,0,0)"});
                    }
                )
            }
            
            $("#toggleButton").attr("aria-expanded","false");
            $(".navbar-collapse").removeClass("show");
           // $("#menuSpy").html(contentMenu[_index]);


        };
     </script>';
     ?>
    </head>


    <body id="couverture">
    
    <div >
        <header class="text-center">
            <h1 id="headerLogo"> 
                <span class="bi bi-shop">
                    </span id=headerLogo>Burger Code<span class="bi bi-shop"></span>
            </h1>
        </header>

    <?php   
        echo'    
        <div id="planche">
            <nav class="navbar navbar-expand-md navbar-dark bg-dark">
                <div class="container-fluid" id="Enseigne">
                    <div class="navbar-brand">
                            <button  id="toggleButton" class="navbar-toggler col-md" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMenu">
                                <span class="navbar-toggler-icon"></span>
                            
                            <a id="menuSpy">Burger Code</a></button>
                    </div>

                    <div class="collapse navbar-collapse" id = "collapseMenu">
                        <div class="container-md" id="boutonColapse">
                             <ul class="nav nav-tabs navbar-nav mr-auto"  role="tablist">';
                                   
                                    

                                   

                                        // créer le menu principal
                                        foreach($categories as $category)
                                        {
                                            if($category['id']=='1')
                                            {
                                                echo ' 
                                                <li class="nav-item">
                                                <button onclick="ScrollToUp()" class="nav-link active" data-bs-toggle="tab" data-bs-target="#panel'. $category['id'] .'"  role="tab">' . $category['name'] . '</button>
                                                </li>';
                                            }
                                            else
                                            {
                                                echo'
                                                <li class="nav-item">
                                                <button onclick="ScrollToUp()"  class="nav-link" data-bs-toggle="tab" data-bs-target="#panel'. $category['id'] .'"   role="tab"  >' . $category['name'] . '</button>
                                                </li>';
                                            }
                                        }


                                echo'
                            </ul>
                        </div>
                    </div>

                </div>
            </nav>    
        </div>

   
        


        <div class="tab-content">';

            foreach($categories as $category)
            {

                    if($category['id']=='1')
                    {
                        echo ' 
                        <div class="tab-pane  show active"   id="panel' . $category['id'] . '" role="tabpanel">';
                        
                    }
                    else
                    {
                        echo ' 
                        <div class="tab-pane"   id="panel' . $category['id'] . '" role="tabpanel">';
                    }

                    echo '<div class="container-md " data-bs-offset="0" >
                    <div class="row myOnglet">';

                    $statement = $db->prepare("SELECT * FROM items WHERE items.category = ?");
                    $statement->execute(array($category['id']));

                    while($item=$statement->fetch())
                    {
                        echo'
                        <div class="card col-sm-6 col-md-6 col-xl-4">
                        <div class="vignette">
                            <div class="card-header">
                                <img class="card-img funImg" src="images/' . $item['image'] . '" alt="Menu Classic" srcset=""> 
                                
                                <div class="align-self-end">
                                    <span class="circle">  0</span>
                                    <span class="price">' . number_format($item['price'],2,'.',' ') . ' XPF</span>
                            
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
                    </div>';

                    }

                    // ferme les div précédentes
                    echo '</div>
                    </div>
                    </div>';

            }

            Database::disconnect(); 

        ?>

    
    </div>
    
    <script >

        //change the size of the elements of the HTML if the height of the menu is more than 60px
        var _currentHeight = $(".container-md").height();

        //update permanent of the index
        $("li").hover(function(){

            _index = $("li").index(this);
            
            $("#menuSpy").html(contentMenu[_index]);
            
            target = contentTabPanel[_index];
        });

        //to do if click
        $(".nav-link").click(ScrollToUp());

        //todo if hover on button
        $(".btn-order").hover(
            function(){
            $(this).parent(".card-footer").parent(".vignette").css({
                    "background":"linear-gradient(24deg, #f5cb12 0%, #ffd2e1 25%, #fff 50%,#ffd2e1 75%,#f5cb12 100%)",
                    "background-size":"600% 600%",
                    "animation": "AnimeGradient 30s ease infinite",
                });
                $(this).parent(".card-footer").parent(".vignette").children(".card-header").children("img").css({
                    "background":"linear-gradient(0deg, #f16026 0%,   #fff 25% ,#f5cb12 50%, #fff 75%, #f16026 100%)",
                    "background-size":"600% 600%",
                    "animation": "AnimeGradient 25s ease infinite",
                });

            

                $(this).click(function(){
                    $(this).parent(".card-footer").parent(".vignette").css({
                        "background":"linear-gradient(0deg, #fff 0%, #757059  100%)",
                        "background-size":"600% 600%",
                        "animation": "AnimeGradient 4s ease 1",
                    });
                    $(this).parent(".card-footer").parent(".vignette").children(".card-header").children("img").css({
                        "background":"linear-gradient(20deg, #f16026 0%,   #fff 25% ,#f5cb12 50%, #fff 75%, #f16026 100%)",
                        "background-size":"600% 600%",
                        "animation": "AnimeGradient 2s ease 1",
                    });
                })

            },
            function(){
                $(this).parent(".card-footer").parent(".vignette").css({"background":"#fff"});

                $(this).parent(".card-footer").parent(".vignette").children(".card-header").children("img").css({
                    "background":"#f5cb12",
                    "background-size":"",
                    "animation": "",
                });

            }
        )

        
    </script>


    <footer class="footPage text-center">
        <br>
        copyright 2021 - anahoa studio
        <br>
    </footer>


</body>

</html>