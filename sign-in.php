<?php
/*
Jermaine Henry
September 28 2021
WEBD3201
*/
$title = "WEBD3201 SIGN-IN-PAGE";
include "./includes/header.php";

//somewhere you make the decision the user needs to be redirected

if($_SERVER["REQUEST_METHOD"] == "GET")
{
    $email = "";
    $password = "";
    $email_error = "";
    $password_error = "";
}
else if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(!filter_var($_POST['EmailAddress'], FILTER_VALIDATE_EMAIL)){
        $message .= "Please enter a valid EmailAddress.<br/>";
    }
    if(empty($_POST['EmailAddress'])){

		$message .= "Please enter your id which is your email address.<br/>";

    } else if(empty($_POST['Password'])){

		$message .= "Please enter a password.<br/>";

    } else if(isset($_POST['EmailAddress']) && isset($_POST['Password'])){
        
        //Store and trim the user Email and password 
        $email = trim($_POST['EmailAddress']);
        $password = trim($_POST['Password']);
        

        //Call the user authenticate function 
        //If true store user info on session
        //then redirect user to dashboard page.
        if($user = user_authenticate($email, $password)){
             //If the user active status is false dont let the user sign-in
             if($user['isactive'] == 'f'){
             
                $message .="The user account " .$email. " has suspended access.";

            }else{

                //Storing user on a session 
                setUser($user);
                print_r($user);

                //Activity logging
                successLog($email);

                //Display message on successful login and redirect
                setMessage("Congrats " .$email. " you logged in successfully your last login time was " .$user["lasttime"]."");
                redirect("./dashboard.php");
            }

        }else{

            //Display message on failed login attempt 
            $message .= "This user was not authenticated properly";
            
            //Activity logging
            failedLog($email);
        }

   
      


    }

}

?>   

<h2><?php echo $message; ?></h2>

<form class="form-signin" action = "<?php echo $_SERVER['PHP_SELF']; ?>" method = "post">
    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
    <label for="inputEmail"  class="sr-only">Email address</label>
    <input type="email" name="EmailAddress" id="EmailAddress" class="form-control" placeholder="Email address" >
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" name="Password" id="Password" class="form-control" placeholder="Password" autofocus>
    <button class="btn btn-lg btn-primary btn-block" name="login" type="submit">Sign in</button>
</form>

<?php
include "./includes/footer.php";
?>    