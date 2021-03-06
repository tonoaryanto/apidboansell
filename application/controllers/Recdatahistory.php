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

		//Record data record
		if($data == '616e73656c6c6a617961696e646f6e65736961'){

			$realtime = $this->dbrealtime();
			$cekrealtime = $realtime->result();
			$urutan = 0;
			foreach ($cekrealtime as $value) {
				$jam = date_format(date_create($value->date_create),"Y-m-d H");
				$esql1 = "SELECT * FROM data_record WHERE kode_perusahaan = '".$value->kode_perusahaan."' AND kode_kandang = '".$value->kode_kandang."' ORDER BY date_create DESC Limit 1";
				$house = $this->db->query($esql1)->row_array();

				$vsetdata = [];

				$setdata = $realtime->row_array($urutan);
				$vsetdata = $this->arraydb('house',$setdata,$jam);

				if($house['growday'] != ''){
					$jam2 = date_format(date_create($house['date_create']),"Y-m-d H");
					if($jam > $jam2){			
						$this->umum_model->insert('data_record',$vsetdata);
						echo 'Hs simpan data terbaru';
						echo '<br>';
						echo $jam2;
						echo '<br>';
						echo $jam;
						echo '<br>';
					}else{
						echo 'Hs Tidak ada data terbaru';
						echo '<br>';
						echo $jam2;
						echo '<br>';
						echo $jam;
						echo '<br>';
					}
				}else{
					$this->umum_model->insert('data_record',$vsetdata);
					echo 'Hs simpan First data';
					echo '<br>';
					echo $jam;
					echo '<br>';
				}

				$urutan = $urutan + 1;
				echo '<br>';
			}
		}

		//Record data egg counter
		if($data == '64617461656767636f756e746572'){
			$realtime = $this->dbrealtime();
			$cekrealtime = $realtime->result();
			$urutan = 0;
			foreach ($cekrealtime as $value) {
				$jam = date_format(date_create($value->date_create),"Y-m-d");
				$esql1 = "SELECT * FROM data_record WHERE kode_perusahaan = '".$value->kode_perusahaan."' AND kode_kandang = '".$value->kode_kandang."' ORDER BY date_create DESC Limit 1";
				$house = $this->db->query($esql1)->row_array();

				$vsetdata2 = [];
				$setdata = $realtime->row_array($urutan);
				$vsetdata2 = $this->arraydb('egg',$setdata,$jam);

				$esql2 = "SELECT * FROM data_eggcounter WHERE kode_perusahaan = '".$value->kode_perusahaan."' AND kode_kandang = '".$value->kode_kandang."' ORDER BY date_create DESC Limit 1";
				$house2 = $this->db->query($esql2)->row_array();

				if($house2['growday'] != ''){
					$jam21 = date_format(date_create($house2['date_create']),"Y-m-d");
					if($jam > $jam21){
						$this->umum_model->insert('data_eggcounter',$vsetdata2);
						echo 'Egg simpan data terbaru';
						echo '<br>';
						echo $jam21;
						echo '<br>';
						echo $jam;
						echo '<br>';
					}else{
						echo 'Egg Tidak ada data terbaru';
						echo '<br>';
						echo $jam21;
						echo '<br>';
						echo $jam;
						echo '<br>';
					}
				}else{
					$this->umum_model->insert('data_eggcounter',$vsetdata2);
					echo 'Egg simpan First data';
					echo '<br>';
					echo $jam;
					echo '<br>';
				}

				$urutan = $urutan + 1;
				echo '<br>';
			}
		}
	}

	private function dbrealtime()
	{
		$isiesql  = "kode_perusahaan";
		$isiesql .= ",kode_kandang";
		$isiesql .= ",req_temp";
		$isiesql .= ",avg_temp";
		$isiesql .= ",temp_1";
		$isiesql .= ",temp_2";
		$isiesql .= ",temp_3";
		$isiesql .= ",temp_4";
		$isiesql .= ",temp_out";
		$isiesql .= ",humidity";
		$isiesql .= ",fan";
		$isiesql .= ",growday";
		$isiesql .= ",static_pressure";
		$isiesql .= ",req_windspeed";
		$isiesql .= ",windspeed";
		$isiesql .= ",silo1";
		$isiesql .= ",silo2";
		$isiesql .= ",alarm1";
		$isiesql .= ",alarm2";
		$isiesql .= ",alarm3";
		$isiesql .= ",water";
		$isiesql .= ",feed";
		$isiesql .= ",min_windspeed";
		$isiesql .= ",max_windspeed";
		$isiesql .= ",date_create";
		$isiesql .= ",periode";
		$isiesql .= ",eggcounter1";
		$isiesql .= ",eggcounter2";
		$isiesql .= ",eggcounter3";
		$isiesql .= ",eggcounter4";
		$isiesql .= ",eggcounter5";
		$isiesql .= ",eggcounter6";
		$isiesql .= ",eggcounter7";
		$isiesql .= ",eggcounter8";
		$isiesql .= ",sumegg";

		$realtime = $this->db->query("SELECT ".$isiesql." FROM data_realtime");
		return $realtime;
	}

	private function arraydb($dt,$setdata,$jam)
	{
		$vsetdata['kode_perusahaan'] = $setdata["kode_perusahaan"];
		$vsetdata['kode_kandang'] = $setdata["kode_kandang"];
		$vsetdata['periode'] = $setdata["periode"];
		$vsetdata['growday'] = $setdata["growday"];
		$vsetdata['date_create'] = $setdata["date_create"];
		$vsetdata['date_record'] = $jam;

		$vsetdata2 = $vsetdata;

		$vsetdata['req_temp'] = $setdata["req_temp"];
		$vsetdata['avg_temp'] = $setdata["avg_temp"];
		$vsetdata['temp_1'] = $setdata["temp_1"];
		$vsetdata['temp_2'] = $setdata["temp_2"];
		$vsetdata['temp_3'] = $setdata["temp_3"];
		$vsetdata['temp_4'] = $setdata["temp_4"];
		$vsetdata['temp_out'] = $setdata["temp_4"];
		$vsetdata['humidity'] = $setdata["humidity"];
		$vsetdata['fan'] = $setdata["fan"];
		$vsetdata['growday'] = $setdata["growday"];
		$vsetdata['static_pressure'] = $setdata["static_pressure"];
		$vsetdata['req_windspeed'] = $setdata["req_windspeed"];
		$vsetdata['windspeed'] = $setdata["windspeed"];
		$vsetdata['silo1'] = $setdata["silo1"];
		$vsetdata['silo2'] = $setdata["silo2"];
		$vsetdata['alarm1'] = $setdata["alarm1"];
		$vsetdata['alarm2'] = $setdata["alarm2"];
		$vsetdata['alarm3'] = $setdata["alarm3"];
		$vsetdata['water'] = $setdata["water"];
		$vsetdata['feed'] = $setdata["feed"];
		$vsetdata['min_windspeed'] = $setdata["min_windspeed"];
		$vsetdata['max_windspeed'] = $setdata["max_windspeed"];
		$vsetdata['date_create'] = $setdata["date_create"];
		$vsetdata['periode'] = $setdata["periode"];

		$vsetdata2['eggcounter1'] = $setdata["eggcounter1"];
		$vsetdata2['eggcounter2'] = $setdata["eggcounter2"];
		$vsetdata2['eggcounter3'] = $setdata["eggcounter3"];
		$vsetdata2['eggcounter4'] = $setdata["eggcounter4"];
		$vsetdata2['eggcounter5'] = $setdata["eggcounter5"];
		$vsetdata2['eggcounter6'] = $setdata["eggcounter6"];
		$vsetdata2['eggcounter7'] = $setdata["eggcounter7"];
		$vsetdata2['eggcounter8'] = $setdata["eggcounter8"];
		$vsetdata2['sumegg'] = $setdata["sumegg"];

		if($dt == 'house'){return $vsetdata;}
		if($dt == 'egg'){return $vsetdata2;}
	}
}
