<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$identitas = $this->input->get("convo_id");
		$pesan = $this->input->get("query");

		$getcontent = file_get_contents("https://botchat.anselljaya.com/chatbot/conversation_star.php?say=$pesan&convo_id=$identitas");

		$hasil = json_decode($getcontent,true);

		echo $hasil["botsay"];
	}
}
