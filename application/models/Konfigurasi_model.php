<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Konfigurasi_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    public function pesan_undefined($expesan)
    {
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

		return $sakit[rand(0,(count($sakit) - 1))];
    }
}
