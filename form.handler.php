<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2018/05/20
 * Time: 6:58 PM
 */

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    //check if its an ajax request, exit if not
    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {

        //exit script outputting json data
        $output = json_encode(
            array(
                'type'=>'error',
                'text' => 'Request is not a valid Ajax request.'
            ));

        die($output);
    }

        //check $_POST vars are set, exit if any missing
        if(!isset($_POST["clientName"]) || !isset($_POST["clientPhone"]) || !isset($_POST["clientEmail"]) || !isset($_POST["clientSubject"]) )
        {
            $output = json_encode(array('type'=>'error', 'text' => 'Highlighted input fields cannot be left blank!'));
            die($output);
        }

        //Sanitize input data using PHP filter_var().
        $name       = filter_var(trim($_POST["clientName"]), FILTER_SANITIZE_STRING);
        $email      = filter_var(trim($_POST["clientEmail"]), FILTER_SANITIZE_EMAIL);
        $phone       = filter_var(trim($_POST["clientPhone"]), FILTER_SANITIZE_STRING);
        $subject       = filter_var(trim($_POST["clientSubject"]), FILTER_SANITIZE_STRING);
        $comments       = filter_var(trim($_POST["clientComments"]), FILTER_SANITIZE_STRING);



        //additional php validation
        if(strlen($name)<4) // If length is less than 4 it will throw an HTTP error.
        {
            $output = json_encode(array('type'=>'error', 'text' => 'Name is too short.'));
            die($output);
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) //email validation
        {
            $output = json_encode(array('type'=>'error', 'text' => 'Please enter a valid email address.'));
            die($output);
        }
        if(strlen($phone)<10) // If length is less than 10 it will throw an HTTP error.
        {
            $output = json_encode(array('type'=>'error', 'text' => 'Phone number is too short.'));
            die($output);
        }
        if(strlen($subject)<4) //check emtpy message
        {
            $output = json_encode(array('type'=>'error', 'text' => 'Subject name is too short.'));
            die($output);
        }

        if(strlen($comments)<5) //check emtpy message
        {
            $output = json_encode(array('type'=>'error', 'text' => 'Message is too short.'));
            die($output);
        }



        $to   	= "Your Email"; //Replace with recipient email address
        //proceed with PHP email.
        $headers = 'From: '.$name.'<'.$email.'>'.'' . "\r\n" .
            'Reply-To: '.$email.'' . "\r\n" .
            'X-Mailer: PHP/' . phpversion().
            'MIME-Version: 1.0' . "\r\n".
            'Content-Type: text/html; charset=UTF-8' . "\r\n";

        $mailBody = "<html>
<head>
  <title>Contact Form Enquiry</title>
</head>
<body>
  <p><strong>From:</strong> $name</p>
  <p><strong>Email:</strong> $email</p>
  <p><strong>Phone:</strong> $phone</p>
  <p><strong>Business Name:</strong> $subject</p>
  <p><strong>Additional Comments:</strong> $comments</p>
</body>
</html>";

        $sentMail = @mail($to, $subject, $mailBody, $headers);
        //$sentMail = true;
        if(!$sentMail)
        {
            $output = json_encode(array('type'=>'error', 'text' => 'Could not send mail! Please contact administrator.'));
            die($output);
        }else{
            $output = json_encode(array('type'=>'success', 'text' => 'Hi '.$name .'</p><p>Thank you for contacting us! Your quote will be back in a flash!</p><p>Keep an eye on those mails.'));
            die($output);
        }

    }