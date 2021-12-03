<?php
    /*
    Jermaine Henry
    Nov 22 2021
    WEBD3201
    */
    $title = "WEBD3201 HOME-PAGE";
    include "./includes/header.php";
    
    //If the user is and admin 
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
                ),
                array(
                "type" => "number",
                "name" => "sales_people",
                "value" => getUserbyType(SALESPERSON),
                "label" => "Select Salesperson" 
                )
            )
        );
        echo "<br/>";
        echo "<br/>";


        /*
        Table Section
        */
        $page = 1;
        //Get the current page number
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }
        echo "<br/>";
        echo "<h1>All Clients</h1>";
        display_table(
            array(
            "email" => "Email",
            "first_name" => "First Name",
            "last_name" => "Last Name",
            "phone_number" => "PhoneNumber"),
            get_Clients(PAGE_RECORDS, $page),
            count_Clients()
        );

    //If user is a Salesperson 
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
        $salesID = $_SESSION['user']['id'];
        echo "<br/>";
        echo "<h1>User Clients</h1>";
        echo "\n<br/>";
  
        display_table(
            array(
            "email" => "Email",
            "first_name" => "First Name",
            "last_name" => "Last Name",
            "phone_number" => "PhoneNumber"),
            get_sales_Client($salesID, 14),
            count_Salesperson(),      
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
    
    
        }else if(empty($_POST['last_name'])){
    
          $message .= "Please enter a Last Name.<br/>";
    
        }else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && empty($_POST['email'])){

            $message .= "Please enter a valid EmailAddress.<br/>";

        }else if(empty($_POST['phone-number']) && is_numeric($_POST['phone-number'])){

            $message .= "Please enter a valid phone number";

            //Validation for the file input should be here
             
        }else{
         
            //Store and trim the client information
            $email = trim($_POST['email']);
            $fName = trim($_POST['first_name']);
            $lName = trim($_POST['last_name']);
            $phoneNum = trim($_POST['phone-number']);

            //Store the Selected Salesperson ID
            $userID = $_POST['sales_people'];

            /*
            To Do File Upload Section
            */
            // $fileName = $_FILES['upload_File']['name'];
            // $tmp_name = $_FILES['files']["tmp_name"];
            // // $uploadPath = '/images';
            // $name= basename($fileName["name"]);
            // move_uploaded_file($fileName, "./upload/$name");
            

            
            //If the user is a salesperson 
            if(isSales()){

                //Get user Salesperson information 
                $salesID = $_SESSION['user']['id'];
                $salesfName = $_SESSION['user']['firstname'];
                $saleslName = $_SESSION['user']['lastname'];
                
                //Upload File 
               

                //Register Client
                register_client($email, $fName, $lName, $phoneNum, $salesID);
                
                //Message for successful Registration
                setMessage("Client".$fName. $lName." was registerd by Salesman ".$_SESSION['user']['firstname']. $_SESSION['user']['lastname']. "");
                echo "Client".$fName.  $lName." was registerd by Salesman ".$_SESSION['user']['firstname']. $_SESSION['user']['lastname']. "";


            }

            if(isAdmin()){
                //Get user Admin information 
                $adminfName = $_SESSION['user']['firstname'];
                $adminlName = $_SESSION['user']['lastname'];

                //Upload File 
                $fileName = $_FILES['upload_File']['name'];

                //Register Client
                register_client($email, $fName, $lName, $phoneNum, $userID, $fileName);
                
                //Message for successful Registration
                setMessage("Client".$fName. $lName." was registerd by Salesman ".$adminfName. $adminlName. "");

                    
            }
            

        }

    }
   
    
?>



<?php
include "./includes/footer.php";
?>    