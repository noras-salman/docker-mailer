<?php

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  require __DIR__."/PHPMailer/PHPMailer.php";
  require __DIR__."/PHPMailer/SMTP.php";
  require __DIR__."/PHPMailer/Exception.php";
class Mailer{
    public static function createMailer($debug=false) {
        $debugMode = $debug ? 2 : 0;
        $mail = new PHPMailer(true);
        
        $mail->CharSet = 'UTF-8';
    
        // Change these values to match your settings
        $mail->Host = MAIL_HOST; // hotmail.com or outlook.com
        $mail->Port = MAIL_PORT;
        $mail->Username = MAIL_USERNAME; // SMTP account username
        $mail->Password = MAIL_PASSWORD; // SMTP account password
     
        $mail->setFrom(MAIL_USERNAME, MAIL_FROM_NAME);
        
        // Uncomment the next line and change the email address
        //   if you don't want replies to go to the from address
        $mail->addReplyTo(MAIL_REPLY_ADRESS);
      
        // Don't change values below this
     
        $mail->IsSMTP(); // use Simple Mail Transfer Protocol
        $mail->SMTPAuth = true; // enable SMTP authentication
        $mail->SMTPSecure = 'tls'; // use Transport Layer Security
        $mail->isHTML(true); // send as HTML
        $mail->SMTPDebug = $debugMode; // Debugging. 0 = no debug output
      
        return $mail;
      }
    
     public static function sendEmail($address,$subject,$body){
        try {
            $mail = Mailer::createMailer(false);
            $mail->addAddress($address);
            $mail->Subject = $subject;
            $mail->Body =$body;
            $mail->AltBody = $body;
        
            $mail->send();
           return true;
          } catch (Exception $e) {
            return $mail->ErrorInfo;
          }
      }

}


?>