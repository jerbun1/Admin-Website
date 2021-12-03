<?php
    /*
    Jermaine Henry
    Oct 4 2021
    WEBD3201
    */
    $title = "WEBD3201 HOME-PAGE";
    include "./includes/header.php";
    
    //If the user is and admin 
    // register_client($email, $fName, $lName, $phoneNum);
    if(isAdmin()){
         
        echo '<h1> Clients Register</h1><br/>';
        display_form(
            array(
                array(
                "type" => "text",
                "name" => "first_name",
                "value" => "",
                "label" => "FirstName"
                ),
                array(
                "type" => "text",
                "name" => "last_name",
                "value" => "",
                "label" => "Last Name"
                ),
                array(
                "type" => "email",
                "name" => "email",
                "value" => "",
                "label" => "Email"
                ),
                array(
                "type" => "number",
                "name" => "phone-number",
                "value" => "",
                "label" => "Phone Number"
                )
            )
        );
        dropDown();

    
    }else if(isSales()){
         
        echo '<h1> Clients Register</h1><br/>';
        display_form(
            array(
                array(
                "type" => "text",
                "name" => "first_name",
                "value" => "",
                "label" => "FirstName"
                ),
                array(
                "type" => "text",
                "name" => "last_name",
                "value" => "",
                "label" => "Last Name"
                ),
                array(
                "type" => "email",
                "name" => "email",
                "value" => "",
                "label" => "Email"
                ),
                array(
                "type" => "number",
                "name" => "phone-number",
                "value" => "",
                "label" => "Phone Number"
                )
            )
        );
    }
   


     

    if($_SERVER["REQUEST_METHOD"] == "GET")
    {
        $email = "";
        $password = "";
        $email_error = "";
        $password_error = "";
    }
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(empty($_POST['first_name'])){

            $message .= "Please enter a First Name";
            // echo "Please enter a First Name";
    
    
        }else if(empty($_POST['last_name'])){
    
          $message .= "Please enter a Last Name.<br/>";
          // echo "Please enter a Last Name.<br/>";
    
        }else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && empty($_POST['email'])){

            $message .= "Please enter a valid EmailAddress.<br/>";

        }else if(empty($_POST['phone-number']) && is_numeric($_POST['phone-number'])){

            $message .= "Please enter a valid phone number";
            // echo "Please enter a Last Name.<br/>";

        }else{
         
            //Store and trim the user Email and password 
            $email = trim($_POST['email']);
            $fName = trim($_POST['first_name']);
            $lName = trim($_POST['last_name']);
            $phoneNum = trim($_POST['phone-number']);
            

            
            //If the user is a salesperson 
            if(isSales()){
                $salesID = $_SESSION['user']['id'];

                register_client($email, $fName, $lName, $phoneNum, $salesID);


            }

            if(isAdmin()){
                register_client($email, $fName, $lName, $phoneNum, $salesID);
            }
            

        }

    }
   
    
?>



<?php
include "./includes/footer.php";
?>    