<?php
/*
Jermaine Henry
Nov 22 2021
WEBD3201
*/

//Function to connect to the database 
function db_connect(){

    return pg_connect("host=".DB_HOST." port=" .DB_PORT." dbname=".DATABASE." user=".DB_ADMIN." password=".DB_PASSWORD);
    
}

//Connection Varaiable
$conn = db_connect();

//Select Prepared Statements
$user = pg_prepare($conn, 'users_select' , "SELECT * FROM users WHERE EmailAddress = $1");
$client = pg_prepare($conn, 'clients_select', "SELECT * FROM clients WHERE FirstName = $1 and LastName =$2");
$selectSales = pg_prepare($conn, "select_sales", "SELECT id, FirstName, LastName FROM users WHERE type = $1");
$selectSalesByType = pg_prepare($conn, "select_users_by_type", "SELECT id, FirstName, LastName FROM users WHERE type = $1");

//Display Salesperson records with pagination
$tableDataSales = pg_prepare($conn, "all_sales_users", "SELECT  EmailAddress, FirstName, LastName, PhoneExtension FROM users ");
$tableDataSales = pg_prepare($conn, "all_sales_users_limit", "SELECT * FROM users where type = $1 LIMIT $2 offset $3");

//Display Client records with pagination
$tableDataClients1 = pg_prepare($conn, "all_client_users_limit", "SELECT EmailAddress, FirstName, LastName, PhoneExtension FROM clients LIMIT $1 offset $2");
$tableDataClients = pg_prepare($conn, "all_client_users", "SELECT EmailAddress, FirstName, LastName, PhoneExtension FROM clients");

//Display only selected data records
$tableDataAdminSales =  pg_prepare($conn, "sales_client_users", "SELECT * FROM clients WHERE users_id = $1 LIMIT $2 offset $3");
$tableDataCalls = pg_prepare($conn, "call_users", "SELECT FirstName, LastName, CallTime, Client_id FROM calls LIMIT $1 OFFSET $2");


//Register Prepared Statements
$regUser = pg_prepare($conn, "register_user", "INSERT INTO users(EmailAddress, FirstName, LastName, Password, CreatedTime, LastTime, PhoneExtension, type) VALUES($1, $2, $3, $4, $5, $6, $7, $8)");
$regClient = pg_prepare($conn, "register_client", "INSERT INTO clients(EmailAddress, FirstName, LastName, PhoneExtension, users_id) VALUES($1, $2, $3, $4, $5)");
$regCalls = pg_prepare($conn, "register_calls", "INSERT INTO calls(FirstName, LastName, CallTime, Client_id) VALUES($1, $2, $3, $4)");

//TO DO Add Logo 
// $addColumn = pg_prepare($conn, 'logo_path', "ALTER TABLE clients ADD COLUMN Logo bytea");
// $uploadFile = pg_prepare($conn, 'upload_file', 'INSERT INTO clients(EmailAddress, FirstName, LastName, PhoneExtension, users_id) VALUES($1, $2, $3, $4, $5)');

$activeUser = pg_prepare($conn, 'activate_user', 'UPDATE users SET IsActive = $1 WHERE id = $2');


//Password Change Statements
$psdChange = pg_prepare($conn, "user_update_password", "UPDATE users SET Password = $1 WHERE id = $2" );

// Function to select the user information from the database
function user_select($id){
    //Connection to the database
    global $conn;
    
    //Execute the prepared statements 
    $result = pg_execute($conn, "users_select", array($id));

    // $result = pg_execute($conn, "select_sales", array($id));  


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

//Function to register user
function register_user($email, $firstName, $lastName, $password, $createdTime, $lastTime, $extension, $type){
    global $conn;

    //Execute the prepared statements 
    $result = pg_execute($conn, "users_select", array($email));

    //Return the user information if true else return false 
    if(pg_num_rows($result) == 1){

        echo 'This user is already registered ';

    }else{

        //Hash the users password
        $hashPassword = password_hash($password, PASSWORD_BCRYPT);

        //Get the date and time 
        $createdTime = date('Y-m-d H:i:s');

        //Update the time 
        $lastTime = $createdTime;
        //Register the user 
        $result = pg_execute($conn, "register_user", array($email, $firstName, $lastName, $hashPassword, $createdTime, $lastTime, $extension, $type));

        return $result;
    }

   
}

//Function to register clients
function register_client($email, $fName, $lName, $phoneNum, $salesID){
    global $conn;

    //Execute the prepared statements 
    $result = pg_execute($conn, "clients_select", array($fName, $lName));

    //Return the user information if true else return false 
    if(pg_num_rows($result) == 1){

        echo 'This user is already registered ';

    }else{

  
    //Register the user 
    $result = pg_execute($conn, "register_client", array($email, $fName, $lName, $phoneNum, $salesID));

    return $result;
    }

   
}

//Function to register calls
function register_calls($fName, $lName, $callTime){
    global $conn;

    $callTime = date('Y-m-d H:i:s');

    $result = pg_execute($conn, "register_calls", array($fName, $lName, $callTime));
    return $result;

}

//Function to display dropdown
function buildDropDown($name, $label, $array){
    global $conn;
   
    $output= '<label>'.$label.'</label><br/>';
        $output .='<select name="'.$name.'">';

        $output .= '<option value="">Select</option>';
            foreach($array as $element){
                $output .='<option value="'.$element['id'].'">'.$element['firstname']. $element['lastname']. '</option>';

            }
            $output .= '</select>';

        return $output;

}

//Function to get the user type 
function getUserbyType($type){
    global $conn;

    $result = pg_execute($conn, 'select_users_by_type', array($type));  

    $users = pg_fetch_all($result);
    return $users;
}


//Function to display all the clients 
function get_Clients($rrp, $page){
    global $conn;

    //Pagination Formula
    $page = ($page-1) * PAGE_RECORDS;

    $result = pg_execute($conn, 'all_client_users_limit', array($rrp, $page));  

    // $users = pg_fetch_assoc($result);


    // return dump($clients);
    return $result;
}

//Function to count all the clients 
function count_Clients(){
    global $conn;


    $result = pg_execute($conn, 'all_client_users', array());  


    $count = pg_num_rows($result);


    // return dump($pageNumber);
    return $count;

    
}

//Function to display all the salespeople
function get_Salesperson($type, $rrp, $page){
    global $conn;

    //Pagination Formula
    $page = ($page-1) * PAGE_RECORDS;

    $result = pg_execute($conn, 'all_sales_users_limit', array($type, $rrp, $page));  

    // $users = pg_fetch_assoc($result);


    // return dump($clients);
    return $result;
}

//Function to count all the salespeople
function count_Salesperson(){
    global $conn;


    $result = pg_execute($conn, 'all_sales_users', array());  


    $count = pg_num_rows($result);


    // return dump($pageNumber);
    return $count;

    
}


//Function to display logged in salespeople clients
function get_sales_Client($id, $limit, $offset){
    global $conn;

    $result = pg_execute($conn, "sales_client_users", array($id, $limit, $offset));

    // $users = pg_fetch_all($result);

    // return dump($users);
    return $result;
}

//Function to Change the users password
function update_password($psd, $id){
    global $conn;

    $hashPassword = password_hash($psd, PASSWORD_BCRYPT);


    $result = pg_execute($conn, 'user_update_password', array($hashPassword, $id));  

    return $result;

}

//Changing the status of the user 
function active_user($active, $id){
    global $conn;

    $result = pg_execute($conn, 'activate_user', array($active, $id));

    return  $result;
}
?>