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
                "type" => "email",
                "name" => "email",
                "value" => "",
                "label" => "Email"
                )
            )
        );
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && empty($_POST['email'])){

            $message .= "Please enter a valid EmailAddress.<br/>";
            echo "Please enter a valid EmailAddress.<br/>";

        }else{
            if(user_select($_POST['email']) == false){
                $message .= 'This Email has not been registered';
                echo 'This Email has not been registered';

            }else{
                $email = $_POST['email'];
                $userEmail = user_select($email);
                $now =  date('Y-m-d H:i:s');
                $subject = "Sending Email to verified user";
                $mail_body = "

                <!DOCTYPE html>
                    <html>
                        <head>
                            <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
                        </head>
                        <body>
                            <h1>Email Verification</h1>
                            <p>Hello ". $userEmail['firstname'] . " ". $userEmail['lastname']  ." We are sending this message to verify the email address of " . $userEmail['emailaddress'] . "(<em>NOTE: This link will expire in two hours</em>):</br> at " .$now . "</p>
                            <p>If you did not request to recieve an email, please ignore this email.</p>
                        </body>
                    </html>

                            ";
                $headers = 'From: webmaster@example.com';
                dump($userEmail);
                // mail($userEmail['emailaddress'], $subject, $mail_body, $headers);
                mailLog($mail_body);

                // $sendEmail =mail($userEmail['emailaddress'], $subject, $mail_body, $headers);
                // mailLog($sendEmail);

            }
        }
    }
?>



<?php
include "./includes/footer.php";
?>    