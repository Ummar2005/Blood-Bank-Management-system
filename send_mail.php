<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

function sendOTP($toEmail, $otp){

    $mail = new PHPMailer(true);

    try{
        // SMTP CONFIG
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'ummarfarukh024@gmail.com';   // 🔁 CHANGE
        $mail->Password   = 'kljsyhwbvuvlxnxc';  // 🔁 CHANGE
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // SENDER
        $mail->setFrom('your_email@gmail.com', 'Blood Bank System');

        // RECEIVER
        $mail->addAddress($toEmail);

        // EMAIL CONTENT
        $mail->isHTML(true);
        $mail->Subject = 'OTP Verification - Blood Bank';

        // 🔥 AUTO VERIFY LINK
        $mail->Body = "
        <h2>Your OTP: <b>$otp</b></h2>
        <p>Enter this OTP in the app.</p>
      
        <p>Click below to verify instantly:</p>
        <a href='http://localhost/blood_project/verify_otp.php?otp=$otp'
           style='padding:10px 20px;background:#28a745;color:#fff;text-decoration:none;border-radius:5px;'>
           Verify Now
        </a>
        <br><br>
        <p>If you did not request this, ignore this email.</p>
        ";

        // SEND
        $mail->send();
        return true;

    } catch (Exception $e){
        return false;
    }
}
?>