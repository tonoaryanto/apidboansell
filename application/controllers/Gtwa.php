<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Gtwa extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('umum_model');
    }

    public function dhouse_get()
    {
        $kode_farm = $this->get('a64617461');
        $kode_kandang = $this->get('686f757365');
        
        $cek_inidata = $this->umum_model->get('data_operator',['pinwa'=>$kode_farm]);
        $datalogin = $cek_inidata->row_array();

        $data = [];
        if($cek_inidata->num_rows() > 0){
            if($kode_kandang == 'all' or $kode_kandang == ''){
                $rawhouse = $this->db->query("SELECT data_kandang.nama_kandang, data_realtime.date_create, data_realtime.req_temp, data_realtime.avg_temp, data_realtime.temp_1, data_realtime.temp_2, data_realtime.temp_3, data_realtime.temp_4, data_realtime.temp_out, data_realtime.humidity, data_realtime.fan, data_realtime.growday, data_realtime.static_pressure, data_realtime.windspeed, data_realtime.silo1,data_realtime.silo2, data_realtime.feed, data_realtime.water, data_realtime.periode FROM data_realtime LEFT JOIN data_kandang ON data_realtime.kode_kandang = data_kandang.id WHERE data_realtime.kode_perusahaan = '".$datalogin['id_user']."'")->result();
                $house['status'] = 1;
                $house['data'] = $rawhouse;
                echo json_encode($house);
            }
        }else{
            $house['status'] = false;
            echo json_encode($house);
        }
    }
}
