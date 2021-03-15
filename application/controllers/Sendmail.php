<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Sendmail extends CI_Controller {

	function __construct(){
		parent::__construct();
        $this->load->model('umum_model');
        require 'vendor/autoload.php';
    }

	public function index()
	{
    }

    public function demo()
    {
        //Send Email  
        // PHPMailer object
        $mail = new PHPMailer();
        // SMTP configuration
        $mail->isSMTP();    
        $mail->Host     = 'smtp.gmail.com'; //sesuaikan sesuai nama domain hosting/server yang digunakan
        $mail->SMTPAuth = true;
        $mail->Username = 'anselljaya.dbo@gmail.com'; // user email
        $mail->Password = 'frontosabiru'; // password email
        $mail->SMTPSecure = 'ssl';
        $mail->Port     = 465;

        $mail->setFrom('anselljaya.dbo@gmail.com', 'Ansell Business Intelligence');
        $mail->addReplyTo('anselljaya.dbo@gmail.com', 'Ansell Business Intelligence');

        // email tujuan mu
        $mail->addAddress('tonoaryanto@gmail.com');
            
        // Email subject
        $mail->Subject = 'SMTP Codeigniter'; //subject email

        // Set email format to HTML
        $mail->isHTML(true);

        // Email body content
        $mailContent = "<h1>SMTP Codeigniterr</h1>
            <p>Laporan email SMTP Codeigniter.</p>"; // isi email
        $mail->Body = $mailContent;

        // Send email
        if(!$mail->send()){
        echo json_encode([
            'status'  => false,
            'message' => 'Mailer Error: ' . $mail->ErrorInfo
            ]);
        }else{
        echo json_encode([
            'status'  => true,
            'message' => "Email telah dikirim."
            ]);
        }
        //END Send Mail
    }
}
