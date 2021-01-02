<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$rawidentitas = $this->input->get("convo_id");

		$extr = explode(" ",$rawidentitas);
		$extr2 = explode("-",$extr[1]);

		$identitas = $extr[0];
		for ($i=0; $i < count($extr2); $i++) { 
			$identitas .= $extr2[$i];
		}

		$pesan = $this->input->get("query");

		$getcontent = file_get_contents("https://botchat.anselljaya.com/chatbot/conversation_start.php?say=$pesan&convo_id=$identitas");

		$hasil = json_decode($getcontent,true);
		
		echo $hasil["botsay"];
	}
}
