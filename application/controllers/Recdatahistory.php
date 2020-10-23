<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recdatahistory extends CI_Controller {

	function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('umum_model');
    }

	public function index()
	{
		$data = $this->input->get('736574686f7572');
		if($data == '616e73656c6c6a617961696e646f6e65736961'){
			$realtime = $this->db->query("SELECT `kode_perusahaan`, `kode_kandang`, `req_temp`, `avg_temp`, `temp_1`, `temp_2`, `temp_3`, `temp_4`, `temp_out`, `humidity`, `fan`, `growday`, `static_pressure`, `req_windspeed`, `windspeed`, `silo1`, `silo2`, `alarm1`, `alarm2`, `alarm3`, `water`, `feed`, `min_windspeed`, `max_windspeed`, `date_create`,`periode` FROM data_realtime");
			$cekrealtime = $realtime->result();
			foreach ($cekrealtime as $value) {
				$jam = date_format(date_create($value->date_create),"Y-m-d H");
				$esql1 = "SELECT * FROM data_record WHERE kode_perusahaan = '".$value->kode_perusahaan."' AND kode_kandang = '".$value->kode_kandang."' ORDER BY date_create DESC Limit 1";
				$house = $this->db->query($esql1)->row_array();

				if($house['growday'] != ''){
					$jam2 = date_format(date_create($house['date_create']),"Y-m-d H");
					if($jam > $jam2){
						$setdata = $realtime->row_array();
						$setdata['date_record'] = $jam;
						$this->umum_model->insert('data_record',$setdata);
						echo 'simpan data terbaru';
					}
					echo '<br>';
					echo $jam2;
					echo '<br>';
					echo $jam;
				}
			}
		}
	}
}
