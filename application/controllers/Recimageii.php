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

                $datadel = $this->db->query("SELECT id,kode_perusahaan,kode_kandang,date_record,feed,water FROM `data_record` where req_temp IS NULL")->result();

                $isideldata = [];
                foreach ($datadel as $value) {
                    $isiupdata = [];
                    $whereupdata = [];
                    $whereupdata['kode_perusahaan'] = $value->kode_perusahaan;
                    $whereupdata['kode_kandang'] = $value->kode_kandang;
                    $whereupdata['date_record'] = $value->date_record;
                    $isiupdata['water'] = $value->water;
                    $isiupdata['feed'] = $value->feed;
                    $this->umum_model->update('data_record',$isiupdata,$whereupdata);
                    $isideldata[] = $value->id;
                }

                if(count($isideldata) > 0){
                    $this->umum_model->delete_multi('data_record','id',$isideldata);
                }
            }
        }

        $cekimage2 = $this->db->query("SELECT id FROM image2")->num_rows();
        if($cekimage2 == 0){
            $this->db->query("ALTER TABLE `image2` auto_increment = 1;");
        }
    }

}