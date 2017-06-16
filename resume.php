<?php
/*
	$mail="free-vel@mail.ru"; // ваша почта
$subject ="Test" ; // тема письма
$text= "Line 1\nLine 2\nLine 3"; // текст письма
if( mail($mail, $subject, $text) )
{ echo 'Успешно отправлено!'; }
else{ echo 'Отправка не удалась!'; }

*/


require_once $_SERVER['DOCUMENT_ROOT'].'/bitrix/php_interface/PHPMailer-master/PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer;
//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 2;
//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';
//Set the hostname of the mail server

//$mail->AuthType = "GSSAPI";
/*
$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
*/

$mail->Host = "mail.tranzit-oil.ru";
//Set the SMTP port number - likely to be 25, 465 or 587
$mail->Port = 465;
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
//Username to use for SMTP authentication
$mail->Username = "tranzit-oil\\noreply";
//Password to use for SMTP authentication
$mail->Password = "6Ty3^v)f";
//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = 'tls';
//Set who the message is to be sent from
$mail->setFrom('noreply@tranzit-oil.ru', 'First Last');

/*
$mail->Host = "smtp.mail.ru";
//Set the SMTP port number - likely to be 25, 465 or 587
$mail->Port = 465;
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
//Username to use for SMTP authentication
$mail->Username = "tranzit-oilru@mail.ru";
//Password to use for SMTP authentication
$mail->Password = "6Ty3^v)f";
//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = 'ssl';
//Set who the message is to be sent from
$mail->setFrom('tranzit-oilru@mail.ru', 'First Last');
*/
//Set who the message is to be sent to
//$mail->addAddress('admin@tranzit-oil.ru', 'John Doe');

//$mail->addAddress('free-vel@mail.ru', 'John Doe');
$mail->addAddress('colorem29@gmail.com', 'John Doe');
//Set the subject line
$mail->Subject = 'PHPMailer SMTP test';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML('gg test');
//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}
die();


/**
 * Отпраляем почту через SMTP-сервер GMail (пользователь: user@gmail.com).
 *
 * @see CEvent::HandleEvent()
 * @see bxmail()
 *
 * @param string $to Адрес получателя.
 * @param string $subject Тема.
 * @param string $message Текст сообщения.
 * @param string $additionalHeaders Дополнительные заголовки передаются Битриксом почти всегда ("FROM" передаётся здесь).
 *
 * @return bool
 */
function custom_mail($to, $subject, $message, $additionalHeaders = '')
{
	/*
	$mail="free-vel@mail.ru"; // ваша почта
$subject ="Test" ; // тема письма
$text= "Line 1\nLine 2\nLine 4"; // текст письма
if( mail($mail, $subject, $text) )
{ echo 'Успешно отправлено!'; }
else{ echo 'Отправка не удалась!'; }
return true;
*/
   /*
    * Настройки можно (нужно) вынести в админку, но это уже домашнее задание :)
    */
   $smtpServerHost         = 'mail.tranzit-oil.ru';
   $smtpServerHostPort      = 2552;
   $smtpServerUser         = 'transit-oil\noreply';
   $smtpServerUserPassword   = '6Ty3^v)f';

   if (!($smtp = new Net_SMTP($smtpServerHost, $smtpServerHostPort))) {
      return false;
   }
   if (PEAR::isError($e = $smtp->connect())) {
      return false;
   }
   if (PEAR::isError($e = $smtp->auth($smtpServerUser, $smtpServerUserPassword))) {
      return false;
   }

 //  preg_match('/From: (.+)\n/i', $additionalHeaders, $matches);
  // list(, $from) = $matches;
   $from = 'admin@tranzit-oil.ru';
   $smtp->mailFrom($from);
   //$smtp->rcptTo($to);
   $smtp->rcptTo('free-vel@mail.ru');

   /*
    * Получаем идентификатор конца строки у Битрикса.
    */
   $eol = CAllEvent::GetMailEOL();

   $additionalHeaders .= $eol . 'Subject: ' . $subject;

   if (PEAR::isError($e = $smtp->data($additionalHeaders . "\r\n\r\n" . $message))) {
      return false;
   }

   $smtp->disconnect();

   return true;
}

custom_mail('free-vel@mail.ru', 'test', 'test 1');
?>
    
