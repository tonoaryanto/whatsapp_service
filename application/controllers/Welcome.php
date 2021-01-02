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

		if(isset($expesan[1])){
			$katakamu = $expesan[1];
			if(isset($expesan[2])){
				for ($i=2; $i < count($expesan); $i++) {
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
					$infocuaca = "To find out the weather where you are currently, please type the following command :\r\n".ucwords($namabot)." weather in <location name> \r\nor \r\n".ucwords($namabot)." cuaca di <nama lokasi> \r\nExample : \r\nJarvis weather in bandung \r\nYou can use additional regions and countries with the following format. \r\n<location>, <region> *(Must English)*, <country> *(Must English)* \r\nExample : \r\nJarvis weather in nagreg, west java \r\nJarvis weather in nagreg, west java, indonesia";
					if(isset($expesan[2]) and isset($expesan[3])){
						$petunjuk = strtolower($expesan[2]);
						$lokasi = strtolower($expesan[3]);
						if(isset($expesan[4])){
							for ($i=4; $i < count($expesan); $i++) {
								$lokasi .= ' '.$expesan[$i];
							}
						}
						if($petunjuk == 'in' or $petunjuk == 'di'){
							$rdtcuaca = @file_get_contents("https://api.weatherapi.com/v1/current.json?key=80aff1b16f50451babc90054210201&q=".$lokasi);
							print_r($rdtcuaca);
							$dtcuaca =  json_decode($rdtcuaca);

							if(isset($dtcuaca->{'location'})){
								$dtlokasi =  $dtcuaca->{'location'};
								$dtsaatini =  $dtcuaca->{'current'};
								$dtshow = "Name : ".$dtlokasi->{'name'};

								$dtshow .= " \r\nRegion : ".$dtlokasi->{'region'};
								$dtshow .= " \r\nCountry : ".$dtlokasi->{'country'};
								$dtshow .= " \r\nLocaltime : ".date_format(date_create($dtlokasi->{'localtime'}),"H:i:s d-m-Y");
								$dtshow .= " \r\nCondition : ".$dtsaatini->{'condition'}->{'text'};
								$dtshow .= " \r\nTemperature : ".$dtsaatini->{'temp_c'}. " C";
								$dtshow .= " \r\nHumidity : ".$dtsaatini->{'humidity'}." %";
								$dtshow .= " \r\nWind : ".$dtsaatini->{'wind_kph'}." km/h";

								echo $dtshow;
							}else{
								echo $lokasi;
								echo "Oops your location is unknown.";
							}
						}else{
							echo $panggilsakit." \r\n".$infocuaca;
						}
					}else{
						echo $infocuaca;
					}
				}else{
					echo $panggilsakit;
				}
			}else{
				echo "Hi. Please type my name followed by the following command: \r\n- weather/cuaca \r\n \r\nExample: ".ucwords($namabot)." weather";
			}
		}else{
			$pesanini = "Hello, I'm ".ucwords($namabot).". I am an Artificial Intelligence. Please wait a moment my master will reply to your chat or you can say *".ucwords($namabot)."* to chat with me.";

			$cek = $this->db->query("SELECT kontak,tanggalwaktu FROM log_user WHERE kontak = '".$identitas."'");
			$ceklast = $cek->num_rows();

			if($ceklast > 0){
				$cekdtsimpan = $cek->row_array();
				$harisimpan = date_format(date_create($cekdtsimpan['tanggalwaktu']), "H");
				$harini = date("H");
				$hinterval = (int)$harini - (int)$harisimpan;
				if($hinterval >= 3){
					$data['tanggalwaktu'] = date("Y-m-d H:i:s");
	
					$this->db->where(['kontak'=>$identitas]);
					$this->db->update("log_user", $data);

					echo $pesanini;
				}else{echo "#false";}
			}else{
				$data['kontak'] = $identitas;
				$data['tanggalwaktu'] = date("Y-m-d H:i:s");

				$this->db->insert("log_user", $data);
				echo $pesanini;
			}
		}
	}
}
