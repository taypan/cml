<? 
/**
 * Mailer.php
 *
 * The Mailer class is meant to simplify the task of sending
 * emails to users. Note: this email system will not work
 * if your server is not setup to send mail.
 *
 * If you are running Windows and want a mail server, check
 * out this website to see a list of freeware programs:
 * <http://www.snapfiles.com/freeware/server/fwmailserver.html>
 *
 * Written by: Jpmaster77 a.k.a. The Grandmaster of C++ (GMC)
 * Last Updated: August 19, 2004
 */
class Mailer
{
   /**
    * sendWelcome - Sends a welcome message to the newly
    * registered user, also supplying the username and
    * password.
    */
	  
	   function sendConfEmail($id, $email,$odkaz){
	  // echo "X".$id."X";
      $from = "From: ".EMAIL_FROM_NAME." <".EMAIL_FROM_ADDR.">";
      $subject = "Objednavka - Overovaci mail";
      $body = "Pro potvrzeni objednavky navstivte nasledujici adresu: ".SITE."/index.php?page=Confirm&id=".$id."&code=".$odkaz."\n\n"
             ."Pokud jste si nic neobjednal/a, tento email prosim ignorujte";
             
      return mail($email,$subject,$body,$from);
   }
   /*****************************************/

}

/* Initialize mailer object */

 
?>
