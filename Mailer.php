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
	var $prevodni_tabulka = Array(
  'ä'=>'a',
  'Ä'=>'A',
  'á'=>'a',
  'Á'=>'A',
  'à'=>'a',
  'À'=>'A',
  'ã'=>'a',
  'Ã'=>'A',
  'â'=>'a',
  'Â'=>'A',
  'č'=>'c',
  'Č'=>'C',
  'ć'=>'c',
  'Ć'=>'C',
  'ď'=>'d',
  'Ď'=>'D',
  'ě'=>'e',
  'Ě'=>'E',
  'é'=>'e',
  'É'=>'E',
  'ë'=>'e',
  'Ë'=>'E',
  'è'=>'e',
  'È'=>'E',
  'ê'=>'e',
  'Ê'=>'E',
  'í'=>'i',
  'Í'=>'I',
  'ï'=>'i',
  'Ï'=>'I',
  'ì'=>'i',
  'Ì'=>'I',
  'î'=>'i',
  'Î'=>'I',
  'ľ'=>'l',
  'Ľ'=>'L',
  'ĺ'=>'l',
  'Ĺ'=>'L',
  'ń'=>'n',
  'ǹ'=>'n',
  'Ń'=>'N',
  'ň'=>'n',
  'Ň'=>'N',
  'ñ'=>'n',
  'Ñ'=>'N',
  'ó'=>'o',
  'Ó'=>'O',
  'ö'=>'o',
  'Ö'=>'O',
  'ô'=>'o',
  'Ô'=>'O',
  'ò'=>'o',
  'Ò'=>'O',
  'õ'=>'o',
  'Õ'=>'O',
  'ő'=>'o',
  'Ő'=>'O',
  'ř'=>'r',
  'Ř'=>'R',
  'ŕ'=>'r',
  'Ŕ'=>'R',
  'š'=>'s',
  'Š'=>'S',
  'ś'=>'s',
  'Ś'=>'S',
  'ť'=>'t',
  'Ť'=>'T',
  'ú'=>'u',
  'Ú'=>'U',
  'ů'=>'u',
  'Ů'=>'U',
  'ü'=>'u',
  'Ü'=>'U',
  'ù'=>'u',
  'Ù'=>'U',
  'ũ'=>'u',
  'Ũ'=>'U',
  'û'=>'u',
  'Û'=>'U',
  'ý'=>'y',
  'Ý'=>'Y',
  'ž'=>'z',
  'Ž'=>'Z',
  'ź'=>'z',
  'Ź'=>'Z');
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

	function sendNotice($email_from,$items,$jmeno){
		// echo "X".$id."X";
		$email = INFO_EMAIL;
		$from = "From: ".EMAIL_FROM_NAME." <".EMAIL_FROM_ADDR.">";
		$polozky = "";
		global $database;
		foreach($items as $key => $value){
			$result = $database->query("SELECT nazev FROM items WHERE id = $value");
			$obj = mysql_fetch_object($result);
			$polozky = $polozky."\n".$obj->nazev. " (http://rukodilna.cz/cml/index.php?page=Detail&id=$value)";
		}

		$subject = "Objednavka";
		$body = "Byla provedena objednavka zbozi.\nJméno: $jmeno\nKontaktni e-mail: $email_from\nPolozky: $polozky\nVice informaci v administraci.";
			
		return mail($email,$subject,strtr($body, $this->prevodni_tabulka),$from);
	}

	/*****************************************/

}

/* Initialize mailer object */


?>
