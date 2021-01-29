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
                $rawhouse = $this->db->query("SELECT `date_create`, `req_temp`, `avg_temp`, `temp_1`, `temp_2`, `temp_3`, `temp_4`, `temp_out`, `humidity`, `fan`, `growday`, `static_pressure`, `windspeed`, `silo1`, `water`, `periode` FROM data_realtime WHERE kode_perusahaan = '".$datalogin['id_user']."'")->result();
                $house['status'] = true;
                $house['data'] = $rawhouse;
                echo json_encode($house);
            }
        }else{
            $house['status'] = false;
            echo json_encode($house);
        }
    }
}
