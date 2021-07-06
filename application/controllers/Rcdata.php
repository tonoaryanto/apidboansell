<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Rcdata extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('umum_model');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function dhouse_get()
    {
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

        $house = $this->db->query("SELECT * FROM data_kandang WHERE id = '".$kode_kandang."'")->row_array();
        $house2 = $this->db->query("SELECT growday,keterangan,reset_time FROM data_record WHERE periode = '".$house['flock']."' AND kode_perusahaan = '".$kode_farm."' AND kode_kandang = '".$kode_kandang."' ORDER BY periode DESC, growday DESC LIMIT 1")->row_array();

        $data['periode'] = $house['flock'];
        $data['date_create'] = date_format(date_create(date("Y-m-d H:i:s")),"Y-m-d H:i:s");
        $date_now = date_format(date_create($data['date_create']),"Y-m-d H").":00:00";

        $date_in = date_format(date_create($house['date_in']),"Y-m-d")." ".date_format(date_create($house['reset_time']),"H:i:s");
        $difftgl1 = date_diff(date_create($date_in),date_create($date_now));
        $data['reset_time'] = $house['reset_time'];

        $growawal = (int)$house['star_growday'] + (int)$difftgl1->format("%R%a");

        $data['keterangan'] = 'ok';
        if((int)$growawal != (int)$data['growday']){
            $data['keterangan'] = 'growchange';            
            //$data['keterangan'] = (int)$growawal.' - '.(int)$data['growday'];
        }
        if($house2['growday'] != ''){
            if($house2['keterangan'] == 'growchange'){
                $data['keterangan'] = 'growchange';            
            }
        }

		$egg1 = 0;
		$egg2 = 0;
		$egg3 = 0;
		$egg4 = 0;
		$egg5 = 0;
		$egg6 = 0;
		$egg7 = 0;
		$egg8 = 0;

        if(isset($data["eggcounter1"])){
            if($data["eggcounter1"] == '8888' or $data["eggcounter1"] == '7777' or $data["eggcounter1"] == '9999'){$egg1 = 0;
            }else{$egg1 = $data["eggcounter1"];}
            $data['eggcounter1'] = $egg1;
        }

        if(isset($data["eggcounter2"]) != ''){
            if($data["eggcounter2"] == '8888' or $data["eggcounter2"] == '7777' or $data["eggcounter2"] == '9999'){$egg2 = 0;
            }else{$egg2 = $data["eggcounter2"];}
            $data['eggcounter2'] = $egg2;
        }

        if(isset($data["eggcounter3"]) != ''){
            if($data["eggcounter3"] == '8888' or $data["eggcounter3"] == '7777' or $data["eggcounter3"] == '9999'){$egg3 = 0;
            }else{$egg3 = $data["eggcounter3"];}
            $data['eggcounter3'] = $egg3;
        }

        if(isset($data["eggcounter4"]) != ''){
            if($data["eggcounter4"] == '8888' or $data["eggcounter4"] == '7777' or $data["eggcounter4"] == '9999'){$egg4 = 0;
            }else{$egg4 = $data["eggcounter4"];}
            $data['eggcounter4'] = $egg4;
        }

        if(isset($data["eggcounter5"]) != ''){
            if($data["eggcounter5"] == '8888' or $data["eggcounter5"] == '7777' or $data["eggcounter5"] == '9999'){$egg5 = 0;
            }else{$egg5 = $data["eggcounter5"];}
            $data['eggcounter5'] = $egg5;
        }

        if(isset($data["eggcounter6"]) != ''){
            if($data["eggcounter6"] == '8888' or $data["eggcounter6"] == '7777' or $data["eggcounter6"] == '9999'){$egg6 = 0;
            }else{$egg6 = $data["eggcounter6"];}
            $data['eggcounter6'] = $egg6;
        }

        if(isset($data["eggcounter7"]) != ''){
            if($data["eggcounter7"] == '8888' or $data["eggcounter7"] == '7777' or $data["eggcounter7"] == '9999'){$egg7 = 0;
            }else{$egg7 = $data["eggcounter7"];}
            $data['eggcounter7'] = $egg7;
        }

        if(isset($data["eggcounter8"]) != ''){
            if($data["eggcounter8"] == '8888' or $data["eggcounter8"] == '7777' or $data["eggcounter8"] == '9999'){$egg8 = 0;
            }else{$egg8 = $data["eggcounter8"];}
            $data['eggcounter8'] = $egg8;
        }

        $data['sumegg'] = $egg1 + $egg2 + $egg3 + $egg4 + $egg5 + $egg6 + $egg7 + $egg8;

        if($cek_inidata->num_rows() == 1){
            $this->umum_model->update('data_realtime',$data,$where);
        }else{
            $this->umum_model->insert('data_realtime',$data);
        }

        if ($kode_farm != '' AND $kode_kandang != '' AND $isidata != ''){
            $this->response('OK', REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
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
        $this->response(date('H').date('i').date('s').date('d').date('m').date('Y'), REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
    }
}
