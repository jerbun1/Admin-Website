<?php  
/*
Jermaine Henry
Nov 22 2021
WEBD3201
*/

//Function to redirect the user to another page
function redirect($url){
    header("Location:".$url);
    ob_flush();
}

//Function to store a message on a session 
function setMessage($msg){
    $_SESSION['message'] = $msg;

}

//Function to get the messaage from the session 
function getMessage(){

    return $_SESSION['message'];
}

//Function to check if the session message is set 
function isMessage(){
    return isset($_SESSION['message']) ? true : false; 
}

//Function to remove the message from the session 
function removeMessage(){
    unset($_SESSION['message']);
}

//Function to flash the message if it is set 
function flashMessage(){
    $message = "";
    if(isMessage()){
        $message = getMessage();
        removeMessage();
    }
    return $message;
}

//Function to set the user data on a session
function setUser($user){
    $_SESSION['user'] = $user;
    return $user;
}


//Function to check if the user is on a session 
function isUser(){
   return  isset($_SESSION['user']) ?  true : false;
}

//Function to remove the user from the session 
function removeUser(){
   if(isset($_SESSION['user'])){
    unset($_SESSION['user']);
   } 
}

// //Checks to see if the user is an Admin 
function isAdmin(){
    if(isset($_SESSION['user']) && $_SESSION['user']['type'] == ADMIN){
        return true;
    }else{
        return false;
    }
    
}
// //Checks to see if the user is a salesperson
function isSales(){
    if(isset($_SESSION['user']['type']) && $_SESSION['user']['type'] == SALESPERSON){
        return true;
    }else{
        return false;
    }
}

//Function to log successful login in a text file
function successLog($email){
    $date = date('Y-m-d');
    $now = date("Y-m-d G:i:s");
    $fileOpen = fopen('logging/'.$date.'_log.txt', 'a');
    fwrite($fileOpen, "\nSign in success at " .$now." User ".$email." sign in");
    fclose($fileOpen);
}

//Function to log failed login in text file 
function failedLog($email){
    $date = date('Y-m-d');
    $now = date("Y-m-d G:i:s");
    $fileOpen = fopen('logging/'.$date.'_log.txt', 'a');
    fwrite($fileOpen, "\nFailed to login at " .$now." with user ".$email.":(");
    fclose($fileOpen);
}

//Function to log logout attempt in a text file 
function logoutLog(){
    $date = date('Y-m-d');
    $now = date("Y-m-d G:i:s");
    $fileOpen = fopen('logging/'.$date.'_log.txt', 'a');
    fwrite($fileOpen, "\nSigned out at " .$now." with user ".$_SESSION['user']["EmailAddress"]);
    fclose($fileOpen);
}

//Function to display a form
function display_form($formElement){
    echo '<form class="form-salespeople" method="POST"  >';
            foreach($formElement as $key => $value){
                echo '<div class="form-group">';
                if(is_array($value['value'])){
                    echo buildDropDown($value['name'],$value['label'],$value['value']);
                }
                else{
                    if(isset($formElement[$key]["label"])){
                        echo '<label for="'.$formElement[$key]["name"].'" >'.$formElement[$key]["label"].'</label><br/>';
                        unset($formElement[$key]["label"]);
                    }
                    echo '<input value="'.$formElement[$key]["value"].'"  type="'.$formElement[$key]["type"].'" name="'.$formElement[$key]["name"].'" >';
                    echo '</div>';
                    echo '<br/>';
                }      
            }
    echo "<br/>";
    echo "<br/>";
    echo '<input type ="submit" value = " Register "/>';
	echo '</form>';	    
}

//Function to display a table with database records 
function display_table($header, $record, $pageNumber){
    
    //Displsy the table header
    echo "\n<table class='table'>";
    echo "\n<thead>";
        foreach($header as $key => $value){
            echo "\n<th scope=\*col\">" . $value . "</th>";
        }
    echo "</thead>";
    echo "<tbody>";
   
    //Get the current page number
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }

  
    //Get total number of pages
    $records =ceil($pageNumber/PAGE_RECORDS);
    
    //Display Table info
    while($row = pg_fetch_array($record)){
        echo "\n<tr>";
        echo "<td>". $row["emailaddress"] . "</td>";
        echo "<td>". $row["firstname"] . "</td>";
        echo "<td>". $row["lastname"] . "</td>";
        echo "<td>". $row["phoneextension"] . "</td>"; 
        echo "</tr>"; 
    }   
    echo"</tbody>";
    echo "</table>";  
      $nextPage = $page + 1;
      $prevPage = $page - 1;
    //Display pagination links
    echo "<nav aria-label='Page navigation example'>";
    echo    "<ul class='pagination'>";
        echo    "<li class='page-item'><a class='page-link' href='?page=".$prevPage."'>Previous</a></li>";
            for($page=1; $page <= $records; $page++){
                echo '<li class="page-item"><a href="?page='.$page.'">'.$page.'</a></li>';
           
            }
    echo    "<li class='page-item'><a class='page-link' href='?page=".$nextPage."'>Next</a></li>";
    echo    "</ul>";
    echo "</nav>";

}

//Function for displaying array information 
function dump($arg){
    echo "<pre>";
        print_r($arg);
    echo "</pre>";

    
}

function upload_error($arr){
    $arr = array(
        1 => 'There is no error, the file uploaded with success',
        2 => 'No file uploaded'
    
    );
}




?>