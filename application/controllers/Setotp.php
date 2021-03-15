<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Setotp extends REST_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model('umum_model');
    }

	public function index_get()
	{
        //PassOTP = 506173734f5450;
        //IniAnsell81 = 496e69416e73656c6c3831;
        if($this->input->get("506173734f5450") == "496e69416e73656c6c3831"){
            $telepon = $this->input->get("phonenumber");
            $kode = $this->umum_model->kode_otp();

            $data = [
                'nomor_telepon' => $telepon,
                'kode_otp' => $kode,
                'keterangan' => '0'
            ];

            $db2 = $this->load->database("whatsapp",TRUE);
            $cek = $db2->query("SELECT id FROM data_otp WHERE nomor_telepon = '".$telepon."'")->num_rows();

            if($cek > 0){
                $db2->update("data_otp", $data,['nomor_telepon'=>$telepon]);
            }else{
                $db2->insert("data_otp", $data);
            }

            if($db2->affected_rows() > 0){
                echo json_encode([
                    'status' => TRUE,
                    'data' => bin2hex($kode)
                ]);
            }else{
                echo json_encode([
                    'status' => FALSE,
                    'message' => 'Bad Reuest'
                ]);
            }
        }else{
            $this->load->view("welcome_message");
        }
    }

	public function cek_get()
	{
        //PassOTP = 506173734f5450;
        //Ansell481 = 416e73656c6c343831;
        if($this->input->get("506173734f5450") == "416e73656c6c343831"){
            $telepon = $this->input->get("phonenumber");
            $name = $this->input->get("name");
            $company = $this->input->get("company");
            $email = $this->input->get("email");

            $db2 = $this->load->database("whatsapp",TRUE);
            $cek = $db2->query("SELECT id FROM data_otp WHERE nomor_telepon = '".$telepon."' AND keterangan = '1'")->num_rows();

            if($cek > 0){
                echo json_encode([
                    'status' => TRUE,
                ]);
            }else{
                echo json_encode([
                    'status' => FALSE,
                ]);
            }
        }
    }

}