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
            $esql1 = "SELECT kategori,nama_data,CONCAT(DATE_FORMAT(image2.tanggal_value,'%Y-%m-%d'),' ',LPAD(SUBSTRING_INDEX(image2.jam_value, '-', 1), 2, '0'),':',LPAD(SUBSTRING_INDEX(SUBSTRING_INDEX(image2.jam_value, '-', 2), '-', -1), 2, '0'),':',LPAD(SUBSTRING_INDEX(image2.jam_value, '-', -1), 2, '0')) date_record, grow_value as growday, isi_value as isidata, kode_perusahaan, kode_kandang, periode FROM image2 ORDER BY kategori ASC";
            $house = $this->db->query($esql1)->result();

            foreach ($house as $value) {
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
                        $str = $this->db->last_query();
                        echo $str.'<br>';
                    }else{
                        $this->umum_model->insert('data_record',$isidata);
                        $str = $this->db->last_query();
                        echo $str.'<br>';
                    }    
                }
            }

            $datadel = $this->db->query("SELECT id,req_temp FROM `data_record` where date_record like '%00:00:00%'")->result();

            $isideldata = [];
            foreach ($datadel as $value) {
                if($value->req_temp == null){
                    $isideldata[] = $value->id;
                }
            }

            if(count($isideldata) > 0){
                $this->umum_model->delete_multi('data_record','id',$isideldata);
            }
            // if($house['growday'] != ''){
            //     $jam2 = date_format(date_create($house['date_create']),"Y-m-d H");
            //     $setdata = $realtime->row_array();
            //     $setdata['date_record'] = $jam;
            //     $this->umum_model->insert('data_record',$setdata);
            //     echo 'simpan data terbaru';
            //     echo '<br>';
            //     echo $jam2;
            //     echo '<br>';
            //     echo $jam;
            // }
        }
    }

    private function cekdata($data)
    {

    }

}