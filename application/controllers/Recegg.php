<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recegg extends CI_Controller {

	function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('umum_model');
    }

	public function index()
	{
		$data = $this->input->get('736574686f7572');

		//Record data egg counter
		if($data == '64617461656767636f756e746572'){
			$realtime2= $this->dbrealtime();
			$cekrealtime2 = $realtime2->result();
			$urutan2 = 0;
			foreach ($cekrealtime2 as $value1) {
				$jam1 = date_format(date_create($value1->date_create),"Y-m-d");

				$vsetdata2 = [];
				$setdata2 = $realtime2->row_array($urutan2);
				$vsetdata2 = $this->arraydb('egg',$setdata2,$jam1);

				$esql2 = "SELECT * FROM data_eggcounter WHERE kode_perusahaan = '".$value1->kode_perusahaan."' AND kode_kandang = '".$value1->kode_kandang."' ORDER BY date_create DESC Limit 1";
				$house2 = $this->db->query($esql2)->row_array();

				if($house2['growday'] != ''){
					$jam21 = date_format(date_create($house2['date_create']),"Y-m-d");
					$jam31 = date_format(date_create(date("Y-m-d H:i:s")),"Y-m-d");
					if($jam1 > $jam21){
						$this->umum_model->insert('data_eggcounter',$vsetdata2);
						//print_r($vsetdata2);
						echo 'Egg simpan data terbaru';
						echo '<br>';
						echo $jam21;
						echo '<br>';
						echo $jam1;
						echo '<br>';
					}else if($jam31 > $jam1 AND $jam31 != $jam21){
						$value2 = $this->db->query("SELECT flock,reset_time,date_in,star_growday FROM data_kandang WHERE id = '".$value1->kode_kandang."'")->row_array();
						$date_in  = date_format(date_create($value2['date_in']),"Y-m-d");
						$difftgl1 = date_diff(date_create($date_in),date_create($jam31));
						$growawal1 = (int)$value2['star_growday'] + (int)$difftgl1->format("%R%a");
						$datakosong1 = [
							"kode_perusahaan" => $value1->kode_perusahaan,
							"kode_kandang" => $value1->kode_kandang,
							"periode" => $value2['flock'],
							"growday" => $growawal1,
							"date_create" => date("Y-m-d H:i:s"),
							"date_record" => $jam31." 00:00:00",
							"keterangan" => "norecord",
							"reset_time" => $value2['reset_time']
						];
						$this->umum_model->insert('data_eggcounter',$datakosong1);
						//print_r($datakosong1);
						echo "No Record";
						echo "<br>";
						echo "<br>";
					}else{
						//print_r($vsetdata2);
						echo 'Egg Tidak ada data terbaru';
						echo '<br>';
						echo $jam21;
						echo '<br>';
						echo $jam1;
						echo '<br>';
					}
				}else{
					$this->umum_model->insert('data_eggcounter',$vsetdata2);
					//print_r($vsetdata2);
					echo 'Egg simpan First data';
					echo '<br>';
					echo $jam1;
					echo '<br>';
				}

				$urutan2 = $urutan2 + 1;
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
		$isiesql .= ",keterangan";
		$isiesql .= ",reset_time";

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
		$vsetdata['keterangan'] = $setdata["keterangan"];
		$vsetdata['reset_time'] = $setdata["reset_time"];

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