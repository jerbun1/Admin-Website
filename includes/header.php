<!doctype html>
<html lang="en">
  <head>
  
  	<?php 
    /*
    Jermaine Henry
    September 28 2021
    WEBD3201
    */
		ob_start();
        session_start();

		include "./includes/constants.php";
		include "./includes/db.php";	
		include "./includes/functions.php";


    
        
        $message = flashMessage();

	?>
	
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title><?php echo $title; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./css/styles.css" rel="stylesheet">

  </head>
  <body>
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Company name</a>
        <ul class="navbar-nav px-3">
        <?php 
            if(isUser()){
               echo "<li class=\"nav-item text-nowrap\">
               <a class=\"nav-link\" href=\"logout.php\">Sign out</a>
                </li>";
            }else{
                echo "";

            }

        ?>
        
        </ul>
    </nav>
    <div class="container-fluid">
      <div class="row">
        
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
            <ul class="nav flex-column">
                <li class="nav-item">
                <a class="nav-link active" href="./dashboard.php">
                    <span data-feather="home"></span>
                    Dashboard <span class="sr-only">(current)</span>
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="./index.php">
                    <span data-feather="file"></span>
                    Index
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="./sign-in.php">
                    <span data-feather="file"></span>
                    Sign-In 
                </a>
                </li>
                <?php 
                    if(isUser() && isAdmin()){
                       echo " <li class=\"nav-item\">
                            <a class=\"nav-link\" href=\"./salespeople.php\">
                                <span data-feather=\"file\"></span>
                                SalesPeople 
                            </a>
                            </li>";
                        echo " <li class=\"nav-item\">
                            <a class=\"nav-link\" href=\"./clients.php\">
                                <span data-feather=\"file\"></span>
                                Clients
                            </a>
                            </li>";

                    }else{
                         echo "";
                    }
                    if(isUser() && isSales()){
                         echo " <li class=\"nav-item\">
                             <a class=\"nav-link\" href=\"./clients.php\">
                                 <span data-feather=\"file\"></span>
                                 Clients
                             </a>
                             </li>";
                             echo " <li class=\"nav-item\">
                             <a class=\"nav-link\" href=\"./calls.php\">
                                 <span data-feather=\"file\"></span>
                                 Calls
                             </a>
                             </li>";
                     }else{
                          echo "";
                     }
                     if(isUser()){
                        echo " <li class=\"nav-item\">
                            <a class=\"nav-link\" href=\"./change_password.php\">
                                <span data-feather=\"file\"></span>
                                Change Password
                            </a>
                            </li>";
        
                    }else{
                         echo "";
                    }

                ?>
               
               
                </ul>
            </div>
        </nav>

        <main class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">