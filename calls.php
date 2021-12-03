<?php
/*
Jermaine Henry
Oct 4 2021
WEBD3201
*/
$title = "WEBD3201 HOME-PAGE";
include_once "./includes/header.php";

echo '<h1> Calls Register</h1><br/>';
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
        )
       
    )
);
// display_table(
//     array(
//     "email" => "Email",
//     "first_name" => "First Name",
//     "last_name" => "Last Name",
//     "phone_number" => "PhoneNumber"),
//     get_salespeople(SALESPERSON, PAGE_RECORDS,$start)

//   );

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
    
        }

        $fName = trim($_POST['first_name']);
        $lName = trim($_POST['last_name']);
        $callTime = trim(date('Y-m-d H:i:s'));
        // $clientId =  $_SESSION['user']['id'];
        register_calls($fName, $lName, $callTime);

    }
?>



<?php
include "./includes/footer.php";
?>    