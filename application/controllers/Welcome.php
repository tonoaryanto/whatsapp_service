<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model('query_model');
    }

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

		$panggilsakit = $this->konfigurasi->pesan_undefined($expesan);

		if(strtolower($expesan[0]) == $namabot){
			if(isset($expesan[1])){
				$perintah = strtolower($expesan[1]);
				if($perintah == 'changename'){
					echo $this->query_model->changename(['expesan' => $expesan, 'nmbot' => $nmbot]);
				}else if($perintah == 'cuaca' or $perintah == 'weather'){
					echo $this->query_model->cuaca(['expesan' => $expesan, 'namabot' => $namabot]);
				}else if($perintah == 'covid19'){
					echo $this->query_model->covid();
				}else if($perintah == 'film' or $perintah == 'movie'){
					echo $this->query_model->film(['expesan' => $expesan, 'namabot' => $namabot]);
				}else if($perintah == 'farm'){
					echo $this->query_model->film(['expesan' => $expesan, 'namabot' => $namabot]);
				}else{
					echo $panggilsakit;
				}
			}else{
				$dipanggil = "";

				$dipanggil .= "Hi. Please type my name followed by the following command: \r\n";
				$dipanggil .="- weather/cuaca \r\n";
				$dipanggil .="- movie/film \r\n";
				$dipanggil .="- covid19 \r\n";
				$dipanggil .="- farm \r\n";
				$dipanggil .=" \r\nExample: ".ucwords($namabot)." weather";

				echo $dipanggil;
			}
		}else{
			echo $this->query_model->firstchat(['expesan' => $expesan,'nmbot' => $nmbot,'identitas' => $identitas]);
		}
	}
}
