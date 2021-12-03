<?php  
/*
Jermaine Henry
September 28 2021
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

}

//Function to check if the user is on a session 
function isUser(){
   return  isset($_SESSION['user']) ?  true : false;
}

//Function to remove the user from the session 
function removeUser(){
    unset($_SESSION['user']);
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

?>