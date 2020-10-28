<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recimageii extends CI_Controller {

	function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('umum_model');
    }

	public function index()
	{
        $data = $this->input->get('646174616664');
        if($data == '66696c65657863656c'){
            $esql1 = "SELECT id,kategori,nama_data,CONCAT(DATE_FORMAT(image2.tanggal_value,'%Y-%m-%d'),' ',LPAD(SUBSTRING_INDEX(image2.jam_value, '-', 1), 2, '0'),':',LPAD(SUBSTRING_INDEX(SUBSTRING_INDEX(image2.jam_value, '-', 2), '-', -1), 2, '0'),':',LPAD(SUBSTRING_INDEX(image2.jam_value, '-', -1), 2, '0')) date_record, grow_value as growday, isi_value as isidata, kode_perusahaan, kode_kandang, periode FROM image2 ORDER BY kategori ASC";
            $house = $this->db->query($esql1);
            if($house->num_rows() > 0){
                foreach ($house->result() as $value) {
                    $uisidata = [];
                    $isidata = [];
                    $where = [];
                    $isidata['kode_perusahaan'] = $value->kode_perusahaan;
                    $isidata['kode_kandang'] = $value->kode_kandang;
                    $isidata['periode'] = $value->periode;
                    $isidata['growday'] = $value->growday;
                    $isidata['date_record'] = $value->date_record;

                    $where = $isidata;
                    $cekdb = $this->umum_model->get('data_record',$where)->num_rows();

                    $dataini = $this->umum_model->cek_kode($value->nama_data,$value->isidata,$value->kategori);
                    $isidata[$dataini[0]] = $dataini[1];
                    $isidata['date_create'] = $value->date_record;

                    if($dataini[2] == '1'){
                        if($cekdb > 0){
                            $uisidata[$dataini[0]] = $dataini[1];
                            $this->umum_model->update('data_record',$uisidata,$where);
                        }else{
                            $this->umum_model->insert('data_record',$isidata);
                        }    
                    }
                    $this->umum_model->delete('image2',['id'=>$value->id]);
                }
            }

            $datadel = $this->db->query("SELECT id,kode_perusahaan,kode_kandang,date_record,periode,growday FROM `data_record` where req_temp IS NULL");
            if($datadel->num_rows() > 0){
                foreach ($datadel->result() as $value) {
                    $isiupdata = [];
                    $whereupdata = [];
                    $whereupdata['kode_perusahaan'] = $value->kode_perusahaan;
                    $whereupdata['kode_kandang'] = $value->kode_kandang;
                    $whereupdata['date_record'] = $value->date_record;
                    $whereupdata['periode'] = $value->periode;
                    $whereupdata['growday'] = (int)$value->growday - 1;
                    $dataclonex = $this->umum_model->get('data_record',$whereupdata);
                    $dataclone = $dataclonex->row_array();
                    if($dataclonex->num_rows() > 0){
                        $isiupdata = [
                            'req_temp' => $dataclone['req_temp'],
                            'avg_temp' => $dataclone['avg_temp'],
                            'temp_1' => $dataclone['temp_1'],
                            'temp_2' => $dataclone['temp_2'],
                            'temp_3' => $dataclone['temp_3'],
                            'temp_4' => $dataclone['temp_4'],
                            'temp_out' => $dataclone['temp_out'],
                            'humidity' => $dataclone['humidity'],
                            'fan' => $dataclone['fan'],
                            'static_pressure' => $dataclone['static_pressure'],
                            'req_windspeed' => $dataclone['req_windspeed'],
                            'windspeed' => $dataclone['windspeed'],
                            'silo1' => $dataclone['silo1'],
                            'silo2' => $dataclone['silo2'],
                            'alarm1' => $dataclone['alarm1'],
                            'alarm2' => $dataclone['alarm2'],
                            'alarm3' => $dataclone['alarm3'],
                            'min_windspeed' => $dataclone['min_windspeed'],
                            'max_windspeed' => $dataclone['max_windspeed']
                        ];
                        $this->umum_model->update('data_record',$isiupdata,['id'=>$value->id]);
                        $this->umum_model->delete('data_record',['id'=>$dataclone['id']]);
                    }
                }
            }

            $cekimage2 = $this->db->query("SELECT id FROM image2")->num_rows();
            if($cekimage2 == 0){
                $this->db->query("ALTER TABLE `image2` auto_increment = 1;");
            }
        }
    }

}