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

		$nmbot = $this->db->query("SELECT id,nama_bot FROM data_bot WHERE keterangan = 'aktif'")->row_array();
		$namabot = $nmbot['nama_bot'];

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
				if($perintah == 'changename'){
					if(isset($expesan[2])){
						$namabaru = strtolower($expesan[2]);
						$this->db->update('data_bot',['nama_bot' => $namabaru],['id'=>$nmbot['id']]);
						$this->db->query("DELETE FROM log_user WHERE id_bot = '".$nmbot['id']."'");
						echo "OK";
					}else{
						echo $panggilsakit;
					}
				}else if($perintah == 'cuaca' or $perintah == 'weather'){
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

								$dtshow .= "*Name* : ".$dtlokasi->{'name'};
								$dtshow .= " \r\n*Region* : ".$dtlokasi->{'region'};
								$dtshow .= " \r\n*Country* : ".$dtlokasi->{'country'};
								$dtshow .= " \r\n*Time Update* : ".date_format(date_create($dtsaatini->{'last_updated'}),"H:i:s d-m-Y");
								$dtshow .= " \r\n*Condition* : ".$dtsaatini->{'condition'}->{'text'};
								$dtshow .= " \r\n*Temperature* : ".$dtsaatini->{'temp_c'}. " C";
								$dtshow .= " \r\n*Humidity* : ".$dtsaatini->{'humidity'}." %";
								$dtshow .= " \r\n*Wind* : ".$dtsaatini->{'wind_kph'}." km/h";

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

					if(isset($dtcovid[0]->{'positif'})){
						$dtshow .= "Coronavirus disease in Indonesia\r\n";
						$dtshow .= " \r\n*Confirmed* : ".$dtcovid[0]->{'positif'};
						$dtshow .= " \r\n*Recovered* : ".$dtcovid[0]->{'sembuh'};
						$dtshow .= " \r\n*Deaths* : ".$dtcovid[0]->{'meninggal'};
						$dtshow .= " \r\n*Treated* : ".$dtcovid[0]->{'dirawat'};
						$dtshow .= " \r\n*Case Fatality Rate* : ".number_format($cfr,2)." %";
						$dtshow .= " \r\n*Cure Rate* : ".number_format($curate,2)." %";	
					}else{
						$dtshow .= "The database isn't ready for now";
					}
					
					echo $dtshow;
				}else if($perintah == 'film' or $perintah == 'movie'){
					$infofilm = "To find out the information about a film, please type the following command :\r\n".ucwords($namabot)." movie <movie title> \r\nor \r\n".ucwords($namabot)." film <Judul film> \r\n\r\nExample : \r\nJarvis movie Conjuring \r\n\r\nYou can use additional year with the following format. \r\n<movie title> *#<year> \r\n\r\nExample : \r\nJarvis Contagion *2011";
					if(isset($expesan[2])){
						$petunjuk = strtolower($expesan[2]);
						if(isset($expesan[3])){
							for ($i=3; $i < count($expesan); $i++) {
								if(str_split($expesan[$i])[0] != "*"){
									$petunjuk .= '%20'.$expesan[$i];
								}
							}
						}

						$tahun = "";
						if(str_split(end($expesan))[0] == "*"){
							$tahun .= explode("*",end($expesan))[1];
							$tahun = "&y=".$tahun; 
						}
						$rdtfilm = @file_get_contents("https://www.omdbapi.com/?plot=full&apikey=5a23a5ae&t=".$petunjuk.$tahun);
						$dtfilm =  json_decode($rdtfilm);
						$dtshow = "";

						if(isset($dtfilm->{'Title'})){
							$dtshow .= "Source of movie information from *IMDb*\r\n";
							$dtshow .= "\r\n*Title* : ".$dtfilm->{'Title'};
							$dtshow .= "\r\n*Rating* : ".$dtfilm->{'imdbRating'}."/10";
							$dtshow .= "\r\n*Released* : ".$dtfilm->{'Released'};
							$dtshow .= "\r\n*Gendre* : ".$dtfilm->{'Genre'};
							$dtshow .= "\r\n*Actors* : ".$dtfilm->{'Actors'};
							$dtshow .= "\r\n*Country* : ".$dtfilm->{'Country'};
							$dtshow .= "\r\n*Production* : ".$dtfilm->{'Production'};
							$dtshow .= "\r\n\r\n*Plot* : \r\n".$dtfilm->{'Plot'};	
						}else{
							$dtshow .= "It looks like the movie you are looking for is not available :(";
						}
	
						echo $dtshow;
					}else{
						echo $infofilm;
					}

				}else{
					echo $panggilsakit;
				}
			}else{
				echo "Hi. Please type my name followed by the following command: \r\n- weather/cuaca \r\n- movie/film \r\n- covid19 \r\n \r\nExample: ".ucwords($namabot)." weather";
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
					$this->db->update("log_user", $data,['id_bot'=>$nmbot['id']]);

					echo $pesanini;
				}else{
					echo $panggilsakit." \r\nPlease type *".ucwords($namabot)."* to chat with me.";
				}
			}else{
				$data['kontak'] = $identitas;
				$data['tanggalwaktu'] = date("Y-m-d H:i:s");
				$data['id_bot'] = $nmbot['id'];

				$this->db->insert("log_user", $data);
				echo $pesanini;
			}
		}
	}
}
