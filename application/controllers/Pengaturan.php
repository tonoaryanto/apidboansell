<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan extends CI_Controller {

	public function index()
	{
		$data = $this->input->get('736574686f7572');
		if($data == '616e73656c6c6a617961696e646f6e65736961'){
			$cekrealtime = $this->db->query("SELECT kode_perusahaan,kode_kandang FROM data_realtime")->result();
			foreach ($cekrealtime as $value) {
				echo $value->kode_perusahaan;
				echo '<br>';
				echo $value->kode_kandang;
				echo '<br>';
			}
			$kode_farm = 1;
			$kode_kandang = 14;
			$growday = 30;
			$house = $this->db->query("SELECT * FROM image2 WHERE kode_perusahaan = '".$kode_farm."' AND kode_kandang = '".$kode_kandang."' ORDER BY periode DESC LIMIT 1")->row_array();
			if($house['grow_value'] != ''){
				if($house['grow_value'] > $growday){
					echo $house['periode'] + 1;
				}else{
					echo $house['periode'];
				}
			}
		}
	}
}
