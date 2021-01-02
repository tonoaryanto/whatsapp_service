<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		echo $this->input->get("convo_id");
		echo $this->input->get("query");
	}
}
