<?php
namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;
use App\Models\UsersModel;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class BaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = [];

	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);
		
	}

	public function sendMail($data)
	{
		// $email = \Config\Services::email();

		$from = isset($data['from']) ? $data['from'] : "info@nene-maru.com";
		$to = isset($data['to']) ? $data['to'] : "alexander116gm@hotmail.com";
		$subject = isset($data['subject']) ? $data['subject'] : "Hello";
		$content = isset($data['content']) ? $data['content'] : "Test Mail";

		// $email->setFrom($from);
		// $email->setTo($to);
		// $email->setSubject($subject);
		// $email->setMessage($content);
		$mail = new PHPMailer(true); //Argument true in constructor enables exceptions

		//From email address and name
		$mail->From = $from;
		$mail->FromName = "NeneMaru";

		//To address and name
		$mail->addAddress($to, "Recepient Name");
		// $mail->addAddress("recepient1@example.com"); //Recipient name is optional

		//Address to which recipient will reply
		$mail->addReplyTo($from, "Reply");

		//CC and BCC
		// $mail->addCC("cc@example.com");
		// $mail->addBCC("bcc@example.com");

		//Send HTML or Plain Text email
		$mail->isHTML(true);

		$mail->Subject = $subject;
		$mail->Body = $content;
		$mail->CharSet = 'UTF-8';
		// $mail->AltBody = "This is the plain text version of the email content";

		try {
			//$mail->send();
			echo "Message has been sent successfully";
			return true;
		} catch (Exception $e) {
			echo "Mailer Error: " . $mail->ErrorInfo;
			return false;
		}


		// return $email->send();
	}
}

date_default_timezone_set('Asia/Tokyo');
