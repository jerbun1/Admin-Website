<?php
/*
Jermaine Henry
September 28 2021
WEBD3201
*/

//Function to connect to the database 
function db_connect(){

    return pg_connect("host=".DB_HOST." port=" .DB_PORT." dbname=".DATABASE." user=".DB_ADMIN." password=".DB_PASSWORD);
    
}

//Connection Varaiable
$conn = db_connect();

//Prepared Statements
$user = pg_prepare($conn, 'users_select' , "SELECT * FROM users WHERE EmailAddress = $1");
$update = pg_prepare($conn, "user_update_login_time", "UPDATE users SET lastTime = $1 WHERE EmailAddress = $2");

//Random Execute Statements Examples
// $result = pg_execute($conn, "users_select", array('mScot@dcmail.ca'));
// $upResult = pg_execute($conn, "user_update_login_time", array('mScot@dcmail.ca'));


// Function to select the user information from the database
function user_select($id){
    //Connection to the database
    global $conn;
    //Execute the prepared statements 
    $result = pg_execute($conn, "users_select", array($id));

    //Return the user information if true else return false 
    if(pg_num_rows($result) == 1){

        $user = pg_fetch_assoc($result, 0);
        return $user;

    }else{

        return  false;
    }
   

}

// Function to authenticate the current user 
function user_authenticate($email, $password){
   global $conn;
    $result = pg_execute($conn, "users_select", array($email));

    if(pg_num_rows($result) == 1)
    {
        $user = pg_fetch_assoc($result, 0);
      
        if(password_verify($password, $user['password']))
        {
            //This was supposed  to correct the time but it wasnt working need to do more research
            // $format = "%Y-%m-%d %I:%M:%S";
            // $strf = strftime($format);
            // print_r(strptime($strf,$format));

            // This Should update the current logged in users enrolrole date to the current time 
            $date = date('Y-m-d H:i:s');
            
            $temp= array($date, $email);
            
            $upResult = pg_execute($conn, "user_update_login_time", $temp);
            
            //Return the user info
            return $user;

        }    
        else
        {
            //Return false if password isnt verified 
            return false;
        }

    }else {
        //Return false if the record isnt in the database 
        return false;
    } 
}




?>