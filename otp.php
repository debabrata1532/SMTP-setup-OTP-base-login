<?php

$server= "localhost";
$user= "root";
$password = "";
$database = "your database name";

$con= mysqli_connect($server,$user,$password,$database);

$email=$_POST['email'];

// first check that entered email id is stored in database or not 

$sql = "select * from otp where email = '$email' ";
$result = mysqli_query($con, $sql);
$count = mysqli_num_rows($result); 
if ($count > 0){
    $otp = rand(11111,999999);   // if email id registered in DB thn genarate random OTP 
    $sql2 = " update otp set otp = '$otp' where email = '$email' ";
    $result = mysqli_query($con, $sql2);
    $html= "Your login OTP code is . $otp " ;
    smtp_mail($email, 'Login OTP', $html);   //Send OTP to registered mail thgroun php mailer

    echo '<form action="success.php" method="post"><input type="text" id="otp" name="otp" class="second_box">
    <button type="submit" class="btn btn-primary second_box" id="otp_submit" onclick="">Submit OTP</button> <div> <span id="msg">Do not refresh the page</span></div>
    </form>';
}
else{
    echo 'You\'re not registered, <a href= "index.php">Click here</a> to register ';

}

// SMTP configuration, this function will call if email id is registered in DB 
// we take SMTP configuration into a function so we can use it easily.

function smtp_mail($to, $subject, $msg){
require 'PHPMailerAutoload.php';

$mail = new PHPMailer;

// $mail->SMTPDebug = 2;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // you can use any mail server you want, Gmail, mailchimp etc
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'example@gmail.com';                 // SMTP username
$mail->Password = 'gmail password';      // SMTP password, if you use another server instead f gmail thn use other credential
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to for SSL use 465

$mail->setFrom('sender@abc.com', 'name of company or sender');
$mail->addAddress($to);     // Add a recipient
// $mail->addAddress('ellen@example.com');               // Name is optional
$mail->addReplyTo('sender@abc.com');   //this is optional, if you don't want any reply from customer thn comment it out
// $mail->addCC('cc@example.com');     // add cc or bcc as your wish
// $mail->addBCC('bcc@example.com');

// $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = $subject;
$mail->Body    = $msg;
// $mail->AltBody = $msg;

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}


}





