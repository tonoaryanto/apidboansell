<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Rcdata extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('umum_model');
    }

    public function dhouse_get()
    {
        // Users from a data store e.g. database
        $kode_farm = $this->get('69646661726d');
        $kode_kandang = $this->get('6964686f757365');
        $isidata = $this->get('a64617461');

        $data = [];
        $data['kode_perusahaan'] = $kode_farm;
        $data['kode_kandang'] = $kode_kandang;

        $b = str_replace("b","",$isidata);
        $cmin = str_replace("ad","-",$b);
        $c = str_replace("a0","z",$cmin);
        $d = explode("x",$c);
        for ($i=0; $i < count($d); $i++) { 
            $e = explode("z",$d[$i]);
            if($e[0] > 0){
                $cek_kode = $this->umum_model->cek_kode($e[0],$e[1]);
                if($cek_kode[2] == '1'){
                    $data[$cek_kode[0]] = $cek_kode[1];
                }
            }
        }

        $where = ['kode_perusahaan'=>$kode_farm, 'kode_kandang'=>$kode_kandang];
        $cek_inidata = $this->umum_model->get('data_realtime',$where);

        $house = $this->db->query("SELECT growday,periode FROM data_record WHERE kode_perusahaan = '".$kode_farm."' AND kode_kandang = '".$kode_kandang."' ORDER BY periode DESC LIMIT 1")->row_array();
        if($house['growday'] != ''){
            if($house['growday'] > $data['growday']){
                $data['periode'] = $house['periode'] + 1;
            }else{
                $data['periode'] = $house['periode'];
            }
        }else{
            $data['periode'] = 1;
        }

        if($cek_inidata->num_rows() == 1){
            $this->umum_model->update('data_realtime',$data,$where);
        }else{
            $this->umum_model->insert('data_realtime',$data);
        }
        // Check if the users data store contains users (in case the database result returns NULL)
        if ($kode_farm != '' AND $kode_kandang != '' AND $isidata != ''){
            $this->response("OK", REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'Bad Reuest'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function nettime_get()
    {
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $ipInfo = file_get_contents('http://ip-api.com/json/' . $ip_address);
        $ipInfo = json_decode($ipInfo);
        $timezone = $ipInfo->timezone;
        date_default_timezone_set($timezone);
        $this->response(date('H').date('i'), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
    }
}
