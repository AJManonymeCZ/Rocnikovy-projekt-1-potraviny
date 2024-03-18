<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  require 'PHPMailer-master/src/Exception.php';
  require 'PHPMailer-master/src/PHPMailer.php';
  require 'PHPMailer-master/src/SMTP.php';

class Mail {


    public function send_mail($recipient,$subject,$message, $headers)
    {

        $mail = new PHPMailer();
        $mail->IsSMTP();

        $mail->SMTPDebug  = 0;
        $mail->SMTPAuth   = TRUE;
        $mail->SMTPSecure = "tls";
        $mail->Port       = 587;
        $mail->Host       = "smtp.gmail.com";
        //$mail->Host       = "smtp.mail.yahoo.com";
        $mail->Username   = "guguj.kaleja@gmail.com";
        $mail->Password   = "ukdi vmet hxkw ipla";

        $mail->IsHTML(true);
        $mail->CharSet="UTF-8";
        $mail->AddAddress($recipient, "recipient-name");
        $mail->SetFrom("fidakaleja@seynam.cz", "Potraviny");
        //$mail->AddReplyTo("reply-to-email", "reply-to-name");
        //$mail->AddCC("cc-recipient-email", "cc-recipient-name");
        $mail->Subject = $subject;
        $mail->addCustomHeader($headers);
        $content = $message;

        $mail->MsgHTML($content);
        if(!$mail->Send()) {
            //echo "Error while sending Email.";
            //var_dump($mail);
            return false;
        } else {
            //echo "Email sent successfully";
            return true;
        }

    }
}


