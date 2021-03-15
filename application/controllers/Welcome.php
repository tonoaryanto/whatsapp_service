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

        $rawextr = "";
		$extr = explode(" ",$rawidentitas);
        for ($i=0; $i < count($extr); $i++) {
            $rawextr = $rawextr.$extr[$i];
        }
        $extr = $rawextr;

        $rawextr2 = "";
		$extr2 = explode("-",$extr);
        for ($i=0; $i < count($extr2); $i++) {
            $rawextr2 = $rawextr2.$extr2[$i];
        }
        $extr2 = $rawextr2;
		$identitas = $extr2;

		$nmbot = $this->db->query("SELECT id,nama_bot FROM data_bot WHERE keterangan = 'aktif'")->row_array();
		$namabot = $nmbot['nama_bot'];

		$expesan = explode(" ",$pesan);

		$panggilsakit = $this->konfigurasi->pesan_undefined($expesan);

		if(strtolower($expesan[0]) == $namabot){
			echo $this->query_model->onchat(['nmbot' => $nmbot,'identitas' => $identitas]);
			if(isset($expesan[1])){
				$perintah = strtolower($expesan[1]);
				if($perintah == 'changename'){
					echo $this->query_model->changename(['expesan' => $expesan, 'nmbot' => $nmbot]);
				}else if($perintah == 'cuaca' or $perintah == 'weather'){
					echo $this->query_model->cuaca(['expesan' => $expesan, 'namabot' => $namabot]);
				}else if($perintah == 'covid19'){
					echo $this->query_model->covid();
				}else if($perintah == 'farm'){
					echo $this->query_model->farm(['expesan' => $expesan, 'namabot' => $namabot]);
				}else{
					echo $panggilsakit;
				}
			}else{
				$dipanggil = "";

				$dipanggil .= "Hi. Please type my name followed by the following command: \r\n";
				$dipanggil .="- farm \r\n";
				$dipanggil .=" \r\nExample: ".ucwords($namabot)." covid19";

				echo $dipanggil;
			}
		}else if(strtolower($expesan[0]) ==  'otp'){
			echo $this->query_model->otp(['expesan' => $expesan,'identitas' => $identitas]);
		}else{
			echo $this->query_model->firstchat(['expesan' => $expesan,'nmbot' => $nmbot,'identitas' => $identitas]);
		}
	}
}
