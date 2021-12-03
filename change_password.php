<?php
    /*
    Jermaine Henry
    Nov 13 2021
    WEBD3201
    */
    $title = "WEBD3201 HOME-PAGE";
    include "./includes/header.php";
    
    if(isUser()){

        display_form(
            array(
                array(
                    "type" => "password",
                    "name" => "password",
                    "value" => "",
                    "label" => "New Password"
                ), 
                array(
                    "type" => "password",
                    "name" => "confirm",
                    "value" => "",
                    "label" => "Re-type password "
                )
            )
        );



    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){ 
        if(empty($_POST['password'])){
  
          $message .= "Please enter a new password.";
            echo 'Please enter a new password.';
        }else if(strlen($_POST['password']) <= 3 ){

            $message .= "Password must be longer than 3 characters.";
            echo 'Password must be longer than 3 characters.';

        }else if(empty($_POST['confirm'])){
  
          $message .= "Please confirm the password.";
          echo "Please confirm the password.";

        } else {


            $psd = trim($_POST['password']);
            $confimPsd = trim($_POST['confirm']);

            $id = $_SESSION['user']['id'];

            update_password($psd, $id);



            setMessage("Password Changed Successfully");
            echo "Password should change";

            redirect("sign-in.php");
        }


    }
?>



<?php
include "./includes/footer.php";
?>    