<?php
  include './includes/header.php';

  //Use Display form functio 
  if(isAdmin()){
    echo '<h1> Sales Register</h1><br/>';
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
          "type" => "password",
          "name" => "password",
          "value" => "",
          "label" => "Password"
        ),
        array(
        "type" => "number",
        "name" => "extension",
        "value" => "",
        "label" => "Extension"
        )
      )
    );

    echo "<br/>";
    

    $page = 1;
    
    //Get the current page number
    if (isset($_GET['page'])) {
      $page = $_GET['page'];
    } else {
      $page = 1;
    }

    echo "<h1>All SalesPeople</h1>";
    echo "<br/>";
    display_table(
        array(
        "email" => "Email",
        "first_name" => "First Name",
        "last_name" => "Last Name",
        "phone_number" => "PhoneNumber"),
        get_Salesperson(SALESPERSON, PAGE_RECORDS, $page),
        count_Salesperson()

    );



  }

    if($_SERVER["REQUEST_METHOD"] == "POST"){ 
      if(empty($_POST['first_name'])){

        $message .= "Please enter a First Name";

      }
      if(empty($_POST['last_name'])){

        $message .= "Please enter a Last Name.<br/>";
        // echo "Please enter a Last Name.<br/>";

      }
      if(empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){

        $message .= "Please enter a valid email address.<br/>";
        // echo "Please enter a Last Name.<br/>";

      }
      if(empty($_POST['password'])){

        $message .= "Please enter a password.<br/>";
    
      }
      if(empty($_POST['extension']) && is_numeric($_POST['extension'])){
        
        $message .= "The Extension cant be empty and must be a number";
        // echo "Please enter a Last Name.<br/>";

      } else {

       

        
        $firstName = trim($_POST['first_name']);
        $lastName = trim($_POST['last_name']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $extension = trim($_POST['extension']);
        $type = 's';
        $createdTime = date('Y-m-d H:i:s');
        $lastTime = $createdTime;

        register_user($email, $firstName, $lastName, $password, $createdTime, $lastTime, $extension, $type);
        $set =  register_user($email, $firstName, $lastName, $password, $createdTime, $lastTime, $extension, $type);

        if($result=$set  ){
          setMessage("Sales Person has been successfully added");
          setMessage("Salesperson".$firstName. $lastName." was created");
          echo "Salesperson".$firstName. $lastName." was created";
        }else{
          setMessage("Sales Person was not created");
        }


      }
      echo $message;
    }

?>



<?php
  include './includes/footer.php';
?>