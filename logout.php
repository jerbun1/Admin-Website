<?php 
/*
Jermaine Henry
September 28 2021
WEBD3201
*/
require_once("./includes/constants.php");
require_once("./includes/db.php");	
require_once("./includes/functions.php");
    
    // //if the user is not logged on or in session then redirect
    //Activity logging
    logoutLog();

    removeUser();

    //This should unset the session
    session_unset();

    //This should destroy the session
    session_destroy();

    //This should restart the session 
    session_start();

    if(removeUser()== false){
        //Session message and redirect back to the sign in page.
        setMessage("This user has sucessfully logged out");

        redirect("sign-in.php");
    }


    
   
       
    


?>