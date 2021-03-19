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
		$this->load->helper('url');

		$this->load->view('welcome_message');
    }

    public function demo()
    {
        //anselldemosend=616e73656c6c64656d6f73656e64
        //anselldm123=616e73656c6c646d313233
        if($this->input->get('616e73656c6c64656d6f73656e64') == '616e73656c6c646d313233'){
        $status = 0;
        $db2 = $this->load->database("whatsapp",TRUE);
        $dtotp = $db2->query("SELECT id,nomor_telepon FROM data_otp WHERE keterangan = '1' ORDER BY tanggal ASC LIMIT 1");

        $dtemail = [];
        if($dtotp->num_rows() > 0){
            $setdtotp = $dtotp->row_array();
            $dtemail = $this->db->query("SELECT id,name,company,email,phonenumber FROM data_demo WHERE phonenumber = '".$setdtotp['nomor_telepon']."'");
            if($dtemail->num_rows() > 0){
                $setdtemail = $dtemail->row_array();
                $id = $this->db->query("SELECT id FROM data_operator ORDER BY id DESC LIMIT 1")->row_array()['id'] + 1;
                $username = str_replace(" ","",strtolower($setdtemail['name']));
                $password = str_replace(" ","",strtolower($setdtemail['name'])).$this->umum_model->acak().$this->umum_model->acak().$this->umum_model->acak();
                $pinwa = $this->umum_model->pinwa();

                $this->umum_model->insert('data_operator',[
                    'id' => $id,
                    'id_user' => '1',
                    'username' => $username,
                    'password' => md5($password),
                    'status_user' => '1',
                    'userlogin' => $setdtemail['name'],
                    'pinwa' => $pinwa
                    ]);
                $this->umum_model->update('data_demo',['id_login' => $id],['id' => $setdtemail['id']]);
                $db2->where(['id' => $setdtotp['id']]);
                $db2->delete('data_otp');
            }else{
                $status = 1;
            }
        }else{
            $status = 1;
        }
        
        if($status == 1){
            echo json_encode([
                'status'  => false,
                'message' => 'No request'
                ]);
            return;
        }

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
        
        // email tujuan mu $setdtemail['name']
        $mail->addAddress($setdtemail['email']);
            
        // Email subject
        $mail->Subject = 'Request a program demo approved'; //subject email

        // Set email format to HTML
        $mail->isHTML(true);

        // Email body content
        $mailContent = '
        <p>
        <table align="justify" border="0" cellpadding="20px" cellspacing="0" width="100%">
        <tr>
        <td>
        Hello, Mr./Mrs. <b>'.ucwords($setdtemail['name']).'</b><br>
        at <b>'.ucwords($setdtemail['company']).'</b> company<br>
        <br>
        Thank you for your interest in <b>Ansell Business Intelligence</b> - "<i>We are best partners for your better farming smarter</i>"<br>
        <br>
        Your account for DEMO of our program has been created.<br>
        You may login to abi.anselljaya.com using the following username and password:<br>
        <br>
        Username : '.$username.'<br>
        Password : '.$password.'<br>
        <br>
        Best Regards,<br>
        <img width="120px;" src="http://abi.anselljaya.com/assets/email/ansellbi.png">
        <br>
        Ansell BI Teams<br>
        PT Ansell Jaya Indonesia<br>
        <br>
        </td>
        </tr>
        </table>
        <table border="0" width="100%">
        <td align="center" colspan="2">
        <img width="120px;" src="http://abi.anselljaya.com/assets/email/ansell.png"><br>
        <label>Follow us</label><br><br>
        <a href="https://www.facebook.com/anselljaya/"><img width="40px;" src="http://abi.anselljaya.com/assets/email/facebook.png"></a>
        <a href="https://twitter.com/AnsellJaya"><img width="40px;" src="http://abi.anselljaya.com/assets/email/twitter.png"></a>
        <a href="https://www.instagram.com/anselljayaindonesia/"><img width="40px;" src="http://abi.anselljaya.com/assets/email/instagram.png"></a>
        <a href="https://www.youtube.com/channel/UCC6GpLMfBll7edZxNAMrFdA"><img width="40px;" src="http://abi.anselljaya.com/assets/email/youtube.png"></a>
        </td>
        </tr>
        </table>
        <br>
        <br>
        <hr>
        <br>
        <table align="justify" border="0" cellpadding="20px" cellspacing="0" width="100%">
        <tr>
        <td>
        Yth, Bapak/Ibu <b>'.ucwords($setdtemail['name']).'</b><br>
        Di Perusahaan <b>'.ucwords($setdtemail['company']).'</b><br>
        <br>
        Terimakasih atas ketertarikan anda terhadap <b>Ansell Business Intelligence</b> - "<i>We are best partners for your better farming smarter</i>"<br>
        <br>
        Akun untuk DEMO program telah berhasil dibuat.<br>
        Anda dapat masuk ke abi.anselljaya.com menggunakan username dan password berikut:<br>
        <br>
        Username : '.$username.'<br>
        Password : '.$password.'<br>
        <br>
        Best Regards,<br>
        <img width="120px;" src="http://abi.anselljaya.com/assets/email/ansellbi.png">
        <br>
        Ansell BI Teams<br>
        PT Ansell Jaya Indonesia<br>
        <br>
        </td>
        </tr>
        </table>
        <table border="0" width="100%">
        <td align="center" colspan="2">
        <img width="120px;" src="http://abi.anselljaya.com/assets/email/ansell.png"><br>
        <label>Follow us</label><br><br>
        <a href="https://www.facebook.com/anselljaya/"><img width="40px;" src="http://abi.anselljaya.com/assets/email/facebook.png"></a>
        <a href="https://twitter.com/AnsellJaya"><img width="40px;" src="http://abi.anselljaya.com/assets/email/twitter.png"></a>
        <a href="https://www.instagram.com/anselljayaindonesia/"><img width="40px;" src="http://abi.anselljaya.com/assets/email/instagram.png"></a>
        <a href="https://www.youtube.com/channel/UCC6GpLMfBll7edZxNAMrFdA"><img width="40px;" src="http://abi.anselljaya.com/assets/email/youtube.png"></a>
        </td>
        </tr>
        </table>
        </p>
        '; // isi email
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

    public function sendback()
    {
        //ansellbacksend=616e73656c6c6261636b73656e64
        //ansellemail123=616e73656c6c656d61696c313233
        if($this->input->get('616e73656c6c6261636b73656e64') == '616e73656c6c656d61696c313233'){
            $id = $this->input->get('id');
            $status = 0;
            $dtemail = [];
            $dtemail = $this->db->query("SELECT id,name,company,email,phonenumber,id_login FROM data_demo WHERE id = '".$id."'");
            if($dtemail->num_rows() > 0){
                $setdtemail = $dtemail->row_array();
                $login = $this->db->query("SELECT username,password FROM data_operator WHERE id_login = '".$setdtemail['id_login']."' ORDER BY id DESC LIMIT 1")->row_array();
                $username = $login['username'];
                $password = $login['password'];
            }else{
                $status = 1;
            }
            
            if($status == 1){
                echo json_encode([
                    'status'  => false,
                    'message' => 'No request'
                    ]);
                return;
            }

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
            
            // email tujuan mu $setdtemail['name']
            $mail->addAddress($setdtemail['email']);
                
            // Email subject
            $mail->Subject = 'Request a program demo approved'; //subject email

            // Set email format to HTML
            $mail->isHTML(true);

            // Email body content
            $mailContent = '
            <p>
            <table align="justify" border="0" cellpadding="20px" cellspacing="0" width="100%">
            <tr>
            <td>
            Hello, Mr./Mrs. <b>'.ucwords($setdtemail['name']).'</b><br>
            at <b>'.ucwords($setdtemail['company']).'</b> company<br>
            <br>
            Thank you for your interest in <b>Ansell Business Intelligence</b> - "<i>We are best partners for your better farming smarter</i>"<br>
            <br>
            Your account for DEMO of our program has been created.<br>
            You may login to abi.anselljaya.com using the following username and password:<br>
            <br>
            Username : '.$username.'<br>
            Password : '.$password.'<br>
            <br>
            Best Regards,<br>
            <img width="120px;" src="http://abi.anselljaya.com/assets/email/ansellbi.png">
            <br>
            Ansell BI Teams<br>
            PT Ansell Jaya Indonesia<br>
            <br>
            </td>
            </tr>
            </table>
            <table border="0" width="100%">
            <td align="center" colspan="2">
            <img width="120px;" src="http://abi.anselljaya.com/assets/email/ansell.png"><br>
            <label>Follow us</label><br><br>
            <a href="https://www.facebook.com/anselljaya/"><img width="40px;" src="http://abi.anselljaya.com/assets/email/facebook.png"></a>
            <a href="https://twitter.com/AnsellJaya"><img width="40px;" src="http://abi.anselljaya.com/assets/email/twitter.png"></a>
            <a href="https://www.instagram.com/anselljayaindonesia/"><img width="40px;" src="http://abi.anselljaya.com/assets/email/instagram.png"></a>
            <a href="https://www.youtube.com/channel/UCC6GpLMfBll7edZxNAMrFdA"><img width="40px;" src="http://abi.anselljaya.com/assets/email/youtube.png"></a>
            </td>
            </tr>
            </table>
            <br>
            <br>
            <hr>
            <br>
            <table align="justify" border="0" cellpadding="20px" cellspacing="0" width="100%">
            <tr>
            <td>
            Yth, Bapak/Ibu <b>'.ucwords($setdtemail['name']).'</b><br>
            Di Perusahaan <b>'.ucwords($setdtemail['company']).'</b><br>
            <br>
            Terimakasih atas ketertarikan anda terhadap <b>Ansell Business Intelligence</b> - "<i>We are best partners for your better farming smarter</i>"<br>
            <br>
            Akun untuk DEMO program telah berhasil dibuat.<br>
            Anda dapat masuk ke abi.anselljaya.com menggunakan username dan password berikut:<br>
            <br>
            Username : '.$username.'<br>
            Password : '.$password.'<br>
            <br>
            Best Regards,<br>
            <img width="120px;" src="http://abi.anselljaya.com/assets/email/ansellbi.png">
            <br>
            Ansell BI Teams<br>
            PT Ansell Jaya Indonesia<br>
            <br>
            </td>
            </tr>
            </table>
            <table border="0" width="100%">
            <td align="center" colspan="2">
            <img width="120px;" src="http://abi.anselljaya.com/assets/email/ansell.png"><br>
            <label>Follow us</label><br><br>
            <a href="https://www.facebook.com/anselljaya/"><img width="40px;" src="http://abi.anselljaya.com/assets/email/facebook.png"></a>
            <a href="https://twitter.com/AnsellJaya"><img width="40px;" src="http://abi.anselljaya.com/assets/email/twitter.png"></a>
            <a href="https://www.instagram.com/anselljayaindonesia/"><img width="40px;" src="http://abi.anselljaya.com/assets/email/instagram.png"></a>
            <a href="https://www.youtube.com/channel/UCC6GpLMfBll7edZxNAMrFdA"><img width="40px;" src="http://abi.anselljaya.com/assets/email/youtube.png"></a>
            </td>
            </tr>
            </table>
            </p>
            '; // isi email
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
}
