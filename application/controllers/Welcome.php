<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$rawidentitas = $this->input->get("convo_id");
		$pesan = $this->input->get("query");

		if($pesan == '' AND $rawidentitas == ''){$this->load->view("welcome_message");return;}

		$extr = explode(" ",$rawidentitas);
		$extr2 = explode("-",$extr[1]);

		$identitas = $extr[0];
		for ($i=0; $i < count($extr2); $i++) { 
			$identitas .= $extr2[$i];
		}

		$namabot = $this->db->query("SELECT nama_bot FROM data_bot WHERE keterangan = 'aktif'")->row_array()['nama_bot'];

		$expesan = explode(" ",$pesan);

		$katakamu = "";
		if(isset($expesan[0])){
			$katakamu = $expesan[0];
			if(isset($expesan[1])){
				for ($i=1; $i < count($expesan); $i++) {
					$katakamu .= ' '.$expesan[$i];
				}
			}
		}

		$sakit[0] = "I don't understand what you are saying.";
		$sakit[1] = "I know you are lonely.";
		$sakit[2] = "You hurt my brain uugggghh.";
		$sakit[3] = "Whatever you say -_-";
		$sakit[4] = 'What is the meaning of "'.$katakamu.'" ?';
		$sakit[5] = "Are you serious about chatting with me?";

		$panggilsakit = $sakit[rand(0,(count($sakit) - 1))];

		if(strtolower($expesan[0]) == $namabot){
			if(isset($expesan[1])){
				$perintah = strtolower($expesan[1]);
				if($perintah == 'cuaca' or $perintah == 'weather'){
					$infocuaca = "To find out the weather where you are currently, please type the following command :\r\n".ucwords($namabot)." weather in <location name> \r\nor \r\n".ucwords($namabot)." cuaca di <nama lokasi> \r\n\r\nExample : \r\nJarvis weather in bandung \r\n\r\nYou can use additional regions and countries with the following format. \r\n<location>, <region> *(Must English)*, <country> *(Must English)* \r\n\r\nExample : \r\nJarvis weather in nagreg, west java \r\nor\r\nJarvis weather in nagreg, west java, indonesia";
					if(isset($expesan[2]) and isset($expesan[3])){
						$petunjuk = strtolower($expesan[2]);
						$lokasi = strtolower($expesan[3]);
						if(isset($expesan[4])){
							for ($i=4; $i < count($expesan); $i++) {
								$lokasi .= '%20'.$expesan[$i];
							}
						}
						if($petunjuk == 'in' or $petunjuk == 'di'){
							$rdtcuaca = @file_get_contents("https://api.weatherapi.com/v1/current.json?key=80aff1b16f50451babc90054210201&q=".$lokasi);
							$dtcuaca =  json_decode($rdtcuaca);

							if(isset($dtcuaca->{'location'})){
								$dtlokasi =  $dtcuaca->{'location'};
								$dtsaatini =  $dtcuaca->{'current'};
								$dtshow = "";

								$dtshow .= "Name : ".$dtlokasi->{'name'};
								$dtshow .= " \r\nRegion : ".$dtlokasi->{'region'};
								$dtshow .= " \r\nCountry : ".$dtlokasi->{'country'};
								$dtshow .= " \r\nTime Update : ".date_format(date_create($dtsaatini->{'last_updated'}),"H:i:s d-m-Y");
								$dtshow .= " \r\nCondition : ".$dtsaatini->{'condition'}->{'text'};
								$dtshow .= " \r\nTemperature : ".$dtsaatini->{'temp_c'}. " C";
								$dtshow .= " \r\nHumidity : ".$dtsaatini->{'humidity'}." %";
								$dtshow .= " \r\nWind : ".$dtsaatini->{'wind_kph'}." km/h";

								echo $dtshow;
							}else{
								echo "Oops your location is unknown.";
							}
						}else{
							echo $panggilsakit." \r\n".$infocuaca;
						}
					}else{
						echo $infocuaca;
					}
				}else if($perintah == 'covid19'){
					$rdtcovid = @file_get_contents("https://api.kawalcorona.com/indonesia/");
					$dtcovid =  json_decode($rdtcovid);

					$rawcon = explode(",",$dtcovid[0]->{'positif'});

					$cvcon = $rawcon[0];
					if(isset($rawcon[1])){
						for ($i=1; $i < count($rawcon); $i++) { 
							$cvcon .= $rawcon[$i];
						}
					}

					$rawd = explode(",",$dtcovid[0]->{'meninggal'});

					$cvdeath = $rawd[0];
					if(isset($rawd[1])){
						for ($i=1; $i < count($rawd); $i++) { 
							$cvdeath .= $rawd[$i];
						}
					}

					$rawc = explode(",",$dtcovid[0]->{'sembuh'});

					$cvcure = $rawc[0];
					if(isset($rawc[1])){
						for ($i=1; $i < count($rawc); $i++) { 
							$cvcure .= $rawc[$i];
						}
					}

					$cfr = floatval($cvdeath) / floatval($cvcon) * 100;
					$curate = floatval($cvcure) / floatval($cvcon) * 100;
					$dtshow = "";

					$dtshow .= "Coronavirus disease in Indonesia\r\n";
					$dtshow .= " \r\nConfirmed : ".$dtcovid[0]->{'positif'};
					$dtshow .= " \r\nRecovered : ".$dtcovid[0]->{'sembuh'};
					$dtshow .= " \r\nDeaths : ".$dtcovid[0]->{'meninggal'};
					$dtshow .= " \r\nTreated : ".$dtcovid[0]->{'dirawat'};
					$dtshow .= " \r\nCase Fatality Rate : ".number_format($cfr,2)." %";
					$dtshow .= " \r\nCure Rate : ".number_format($curate,2)." %";
					
					echo $dtshow;
				}else{
					echo $panggilsakit;
				}
			}else{
				echo "Hi. Please type my name followed by the following command: \r\n- weather/cuaca \r\n- covid19 \r\n \r\nExample: ".ucwords($namabot)." weather";
			}
		}else{
			$pesanini = "Hello, I'm ".ucwords($namabot).". I am an Artificial Intelligence. You can type *".ucwords($namabot)."* to chat with me.";

			$cek = $this->db->query("SELECT kontak,tanggalwaktu FROM log_user WHERE kontak = '".$identitas."'");
			$ceklast = $cek->num_rows();

			if($ceklast > 0){
				$cekdtsimpan = $cek->row_array();
				
				$jamsimpan = str_pad(date_format(date_create($cekdtsimpan['tanggalwaktu']), "Y"), 4, '0', STR_PAD_LEFT).str_pad(date_format(date_create($cekdtsimpan['tanggalwaktu']), "m"), 2, '0', STR_PAD_LEFT).str_pad(date_format(date_create($cekdtsimpan['tanggalwaktu']), "d"), 2, '0', STR_PAD_LEFT).str_pad(date_format(date_create($cekdtsimpan['tanggalwaktu']), "H"), 2, '0', STR_PAD_LEFT);
				
				$jamini = str_pad(date("Y"), 4, '0', STR_PAD_LEFT).str_pad(date("m"), 2, '0', STR_PAD_LEFT).str_pad(date("d"), 2, '0', STR_PAD_LEFT).str_pad(date("H"), 2, '0', STR_PAD_LEFT);

				$hinterval = (int)$jamini - (int)$jamsimpan;
				if($hinterval >= 3){
					$data['tanggalwaktu'] = date("Y-m-d H:i:s");
	
					$this->db->where(['kontak'=>$identitas]);
					$this->db->update("log_user", $data);

					echo $pesanini;
				}else{
					echo $panggilsakit." \r\nPlease type *".ucwords($namabot)."* to chat with me.";
				}
			}else{
				$data['kontak'] = $identitas;
				$data['tanggalwaktu'] = date("Y-m-d H:i:s");

				$this->db->insert("log_user", $data);
				echo $pesanini;
			}
		}
	}
}
