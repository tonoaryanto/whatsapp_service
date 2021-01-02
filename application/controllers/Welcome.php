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

		$ceklast = $this->db->query("SELECT kontak,tanggalwaktu FROM log_user WHERE kontak = '".$identitas."'")->num_rows();

		$namabot = $this->db->query("SELECT nama_bot FROM data_bot WHERE keterangan = 'aktif'")->row_array()['nama_bot'];

		$expesan = explode(" ",$pesan);

		$katakamu = "";
		if(isset($expesan[1])){
			for ($i=1; $i < count($expesan); $i++) {
				$katakamu .= ' '.$expesan[$i];
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
			$hi = "If you want to chat with me, please type my name followed by the following command: \r\n weather/cuaca \r\n \r\n Example: ".ucwords($namabot)." weather";
			if(isset($expesan[1])){
				$perintah = strtolower($expesan[1]);
				if($perintah == 'cuaca' or $perintah == 'weather'){
					$infocuaca = "To find out the weather where you are currently, please type the following command : \r\n ".ucwords($namabot)." weather in <location name> \r\n or \r\n ".ucwords($namabot)." cuaca di <nama lokasi>";
					if(isset($expesan[2]) and isset($expesan[3])){
						$petunjuk = strtolower($expesan[2]);
						$lokasi = strtolower($expesan[3]);						
						if($petunjuk == 'in' or $petunjuk == 'di'){
							$rdtcuaca = file_get_contents("https://api.weatherapi.com/v1/current.json?key=80aff1b16f50451babc90054210201&q=".$lokasi);
							$dtcuaca =  json_decode($rdtcuaca);

							$dtlokasi =  $dtcuaca->{'location'};
							if(isset($dtlokasi)){
								$dtsaatini =  $dtcuaca->{'current'};
								$dtshow = "Name : ".$dtlokasi->{'name'};

								$dtshow .= " \r\n Region : ".$dtlokasi->{'region'};
								$dtshow .= " \r\n Country : ".$dtlokasi->{'country'};
								$dtshow .= " \r\n Localtime : ".date_format(date_create($dtlokasi->{'localtime'}),"H:i:s d-m-Y");
								$dtshow .= " \r\n Condition : ".$dtsaatini->{'condition'}->{'text'};
								$dtshow .= " \r\n Temperature : ".$dtsaatini->{'temp_c'}. " C";
								$dtshow .= " \r\n Humidity : ".$dtsaatini->{'humidity'}." %";
								$dtshow .= " \r\n Wind : ".$dtsaatini->{'wind_kph'}." km/h";

								echo $dtshow;
							}else{
								echo "Oops your location is unknown.";
							}
						}else{
							echo $panggilsakit." \r\n ".$infocuaca;
						}
					}else{
						echo $infocuaca;
					}
				}else{
					echo $panggilsakit;
				}
			}else{
				echo "Hi. ".$hi;
			}
		}else{
			echo "Hello, I'm ".ucwords($namabot).". I am an Artificial Intelligence. Please wait a moment my master will reply to your chat or you can say *".ucwords($namabot)."* to chat with me.";
		}
	}
}
